<?php

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::query()->delete();
        Partner::create([
            //'title' => 'Fyber',
            'title' => 'Крутые задания',
            'description' => 'Зарабатывай с партнером',
            'award' => '1.00',
            'top' => 1,
            'image_url' => 'fyber-logo.png',
            'lang' => 'ru'
        ]);
        Partner::create([
            'title' => 'OfferToro',
            'description' => 'Зарабатывай с партнером',
            'award' => '1.00',
            'image_url' => 'offertoro.png',
            'lang' => 'ru'
        ]);
        Partner::create([
            'title' => 'Cool Tasks',
            'description' => 'Earn with a partner',
            'award' => '1.00', 'top' => 1,
            'image_url' => 'fyber-logo.png',
            'lang' => 'en'
            ]);
        Partner::create([
            'title' => 'Best deals',
            'description' => 'Earn with a partner',
            'award' => '1.00',
            'image_url' => 'offertoro.png',
            'lang' => 'en'
            ]);
        /*Partner::create([
            'title' => 'AdsCent',
            'description' => 'Зарабатывай с партнером',
            'award' => '1.00',
            'image_url' => 'adscent.png',
        ]);
        Partner::create([
            'title' => 'TapJoy',
            'description' => 'Зарабатывай с партнером',
            'award' => '1.00',
            'image_url' => 'tapjoy.png',
        ]);
        Partner::create([
            'title' => 'TrialPay',
            'description' => 'Зарабатывай с партнером',
            'award' => '1.00',
            'image_url' => 'trialpay.png',
        ]);
        Partner::create([
            'title' => 'AdTrial',
            'description' => 'Зарабатывай с партнером',
            'award' => '1.00',
            'image_url' => 'adtrial.png',
        ]);*/
    }
}
