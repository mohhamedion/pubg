<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class SendTaskUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;

    private $task;

    /**
     * Create a new job instance.
     *
     * @param $message
     * @param $task
     */
    public function __construct($message,Task $task)
    {
        $this->message = $message;
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('NewApp');
        $notificationBuilder->setBody($this->message)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $user_query = $this->task->users()->wherePivot('is_accepted', 1)->whereNotNull('fcm_token')->where('fcm_token', '!=', '');

        $user_query->chunk(800, function (Collection $users) use ($option, $data, $notification) {

            $tokens = $users->pluck('fcm_token')->toArray();

            $response = FCM::sendTo($tokens, $option, $notification, $data);

            $tokens = null;

            foreach ($response->tokensToDelete() as $token) {
                User::whereFcmToken($token)->update(['fcm_token' => null]);
            }

            foreach ($response->tokensToModify() as $old_token => $new_token) {
                User::whereFcmToken($old_token)->update(['fcm_token' => $new_token]);
            }
        });
    }
}
