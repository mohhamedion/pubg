<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class SendEventNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $notificationBuilder->setBody(trans('messages.event', [], 'ru') )
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $this->user->fcm_token;

        if ($token) {
            $response = FCM::sendTo($token, $option, $notification, $data);

            $tokens = null;

            foreach ($response->tokensToDelete() as $token) {
                User::whereFcmToken($token)->update(['fcm_token' => null]);
            }

            foreach ($response->tokensToModify() as $old_token => $new_token) {
                User::whereFcmToken($old_token)->update(['fcm_token' => $new_token]);
            }
        }
    }
}
