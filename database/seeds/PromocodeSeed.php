<?php

use App\Models\Promocode;
use Illuminate\Database\Seeder;

class PromocodeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = [
            'CASH',
            'BONUS',
            'PROMO',
            'MoneyTime',
            'MONEYTIME',
            'Moneytime',
            'moneytime',
        ];

        foreach ($codes as $code) {
            Promocode::create([
                'code' => $code,
            ]);
        }

    }
}
