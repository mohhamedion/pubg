<?php

use App\Models\CardTransaction;
use Illuminate\Database\Seeder;

class CardTransactionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CardTransaction::create([
            'title' => 'WebMoney',
            'top' => 1,
            'image' => 'webmoney-l1.png',
        ]);
        CardTransaction::create([
            'title' => 'YandexMoney',
            'image' => 'yandex-l2.png',
        ]);
        CardTransaction::create([
            'title' => 'Qiwi',
            'top' => 1,
            'image' => 'qiwi-l4.png',
        ]);
        CardTransaction::create([
            'title' => 'МТС',
            'image' => 'MTS-l2.png',
        ]);
        CardTransaction::create([
            'title' => 'Tele2',
            'image' => 'tele2-l.png',
        ]);
        CardTransaction::create([
            'title' => 'Мегафон',
            'image' => 'megafon-l2.png',
        ]);
        CardTransaction::create([
            'title' => 'Beeline',
            'image' => 'beeline-l1.png',
        ]);
        CardTransaction::create([
            'title' => 'PayPal',
            'top' => 1,
            'image' => 'paypal-1.png',
        ]);
        CardTransaction::create([
            'title' => 'World of Tanks',
            'image' => 'wot.png',
        ]);
        CardTransaction::create([
            'title' => 'Warface',
            'image' => 'log-warface.png',
        ]);
        CardTransaction::create([
            'title' => 'Steam',
            'top' => 1,
            'image' => 'steam-logo.png',
        ]);
        CardTransaction::create([
            'title' => 'Голоса Вконтакте',
            'image' => 'vk-logo.png',
        ]);
    }
}
