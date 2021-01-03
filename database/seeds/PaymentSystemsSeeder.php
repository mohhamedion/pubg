<?php

use App\Models\PaymentSystem;
use Illuminate\Database\Seeder;

class PaymentSystemsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_systems')->truncate();

        foreach (PaymentSystem::PAYMENT_SYSTEMS as $payment_system) {
            PaymentSystem::query()->create($payment_system);
        }
    }
}
