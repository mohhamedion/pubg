<?php

use Illuminate\Database\Seeder;
use App\Models\Referral;

class ReferralSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referral::create([
            'description' => 'Приводи друзей и получай до 30% от их дохода'
        ]);
    }
}
