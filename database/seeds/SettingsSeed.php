<?php

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeed extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // inserting settings options
        Settings::query()->firstOrCreate([
            'email' => 'notification@app.com',
            'rate' => 1,
            'exchange_rate_rub_uah' => 2.45,
            'application_downloads_min_limit' => 10,
            'withdraw_limit' => 117.55,
            'withdraw_commission' => 18,
            'transfer_commission' => 15,
            //'referral_first_balance_limit' => 50,
            //'referral_first_reward_percentage' => 30,
            //'referral_second_balance_limit' => 100,
           // 'referral_second_reward_percentage' => 30,
            //'referral_second_reward_time' => 3600,
            'task_reminder_text' => 'Эй, не забудь запустить задание!',
            'award_standard_task_video' => 0.05,
            'award_standard_task_vk_group' => 2.0,
        ]);
    }
}
