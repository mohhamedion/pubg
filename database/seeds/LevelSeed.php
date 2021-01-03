<?php

use App\Models\RateAward;
use Illuminate\Database\Seeder;

class LevelSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RateAward::create([
            'level' => 1,
            'task' => 1,
            'video' => 1,
            'partner' => 1,
            'referral' => 10
        ]);
        RateAward::create([
            'level' => 2,
            'task' => 2,
            'video' => 2,
            'partner' => 2,
            'referral' => 15
        ]);
        RateAward::create([
            'level' => 3,
            'task' => 3,
            'video' => 3,
            'partner' => 3,
            'referral' => 20
        ]);
        RateAward::create([
            'level' => 4,
            'task' => 4,
            'video' => 4,
            'partner' => 4,
            'referral' => 25
        ]);
        RateAward::create([
            'level' => 5,
            'task' => 5,
            'video' => 5,
            'partner' => 5,
            'referral' => 30
        ]);
    }
}
