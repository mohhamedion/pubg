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

class SendCustomNotificationToDevice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;

    private $fcm_token;

    /**
     * Create a new job instance.
     *
     * @param $message
     * @param $token
     */
    public function __construct($message, $token)
    {
        $this->message = $message;
        $this->fcm_token = $token;
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

        $notificationBuilder = new PayloadNotificationBuilder('Cashrewards');
		
		$notificationBuilder->setBody($this->message)->setSound('default');

        $dataBuilder = new PayloadDataBuilder();

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $this->fcm_token;

        if ($token) {
            $response = FCM::sendTo($token, $option, $notification, $data);
			
			file_put_contents("0.txt", print_r($response, true));
			file_put_contents("1.txt", print_r($this->message, true));

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
