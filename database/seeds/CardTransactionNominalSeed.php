<?php

use Illuminate\Database\Seeder;
use App\Models\CardTransactionNominal;

class CardTransactionNominalSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CardTransactionNominal::create(['amount' => 700]);
        CardTransactionNominal::create(['amount' => 800]);
        CardTransactionNominal::create(['amount' => 900]);
        CardTransactionNominal::create(['amount' => 1000]);
    }
}
