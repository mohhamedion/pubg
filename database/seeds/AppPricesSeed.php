<?php

use App\Models\AppPrice;
use Illuminate\Database\Seeder;

class AppPricesSeed extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Session::put('country', 'Russia'); // For correct insert in RUB currency
        AppPrice::query()->firstOrCreate([
            'android_24h_price_first_user' => 0.9,
            'android_24h_price_second_user' => 0.7,
            'android_24h_price_third_user' => 0.6,
            'android_24h_price_fourth_user' => 0.5,
            'android_24h_price_first_manager' => 0.98,
            'android_24h_price_second_manager' => 0.78,
            'android_24h_price_third_manager' => 0.68,
            'android_24h_price_fourth_manager' => 0.58,
            'ios_24h_price_first_user' => 2.99,
            'ios_24h_price_second_user' => 1,
            'ios_24h_price_third_user' => 1,
            'ios_24h_price_fourth_user' => 1,
            'ios_24h_price_first_manager' => 3.99,
            'ios_24h_price_second_manager' => 1,
            'ios_24h_price_third_manager' => 1,
            'ios_24h_price_fourth_manager' => 1,

            'android_48h_price_first_user' => 0.9,
            'android_48h_price_second_user' => 0.7,
            'android_48h_price_third_user' => 0.6,
            'android_48h_price_fourth_user' => 0.5,
            'android_48h_price_first_manager' => 0.98,
            'android_48h_price_second_manager' => 0.78,
            'android_48h_price_third_manager' => 0.68,
            'android_48h_price_fourth_manager' => 0.58,
            'ios_48h_price_first_user' => 2.99,
            'ios_48h_price_second_user' => 1,
            'ios_48h_price_third_user' => 1,
            'ios_48h_price_fourth_user' => 1,
            'ios_48h_price_first_manager' => 3.99,
            'ios_48h_price_second_manager' => 1,
            'ios_48h_price_third_manager' => 1,
            'ios_48h_price_fourth_manager' => 1,

            'android_72h_price_first_user' => 0.9,
            'android_72h_price_second_user' => 0.7,
            'android_72h_price_third_user' => 0.6,
            'android_72h_price_fourth_user' => 0.5,
            'android_72h_price_first_manager' => 0.98,
            'android_72h_price_second_manager' => 0.78,
            'android_72h_price_third_manager' => 0.68,
            'android_72h_price_fourth_manager' => 0.58,
            'ios_72h_price_first_user' => 2.99,
            'ios_72h_price_second_user' => 1,
            'ios_72h_price_third_user' => 1,
            'ios_72h_price_fourth_user' => 1,
            'ios_72h_price_first_manager' => 3.99,
            'ios_72h_price_second_manager' => 1,
            'ios_72h_price_third_manager' => 1,
            'ios_72h_price_fourth_manager' => 1,
        ]);
    }
}
