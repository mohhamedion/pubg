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

class SendNewTaskNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $task;


    public function __construct(Task $task)
    {
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
        $notificationBuilder->setBody(trans('messages.new_tasks', [], 'ru'))
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['type' => 'new_tasks']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $cis = [
            219,
            220,
            221,
            222,
            227,
            236,
            280,
            341,
            397,
            407,
            411
        ];

        $user_query = User::whereNotNull('fcm_token')->where('fcm_token', '!=', '')
            ->whereIn('country_id', $cis);

        if ($this->task->country_id) {
            $user_query->whereCountryId($this->task->country_id);
        }

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
