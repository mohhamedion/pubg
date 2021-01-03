<?php

use App\Models\LevelLimit;
use Illuminate\Database\Seeder;

class LevelLimitSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LevelLimit::create([
            'level' => 1,
            'task' => 50,
            'video' => 300,
            'partner' => 5,
            'referral' => 3
        ]);
        LevelLimit::create([
            'level' => 2,
            'task' => 100,
            'video' => 600,
            'partner' => 10,
            'referral' => 8
        ]);
        LevelLimit::create([
            'level' => 3,
            'task' => 180,
            'video' => 1000,
            'partner' => 15,
            'referral' => 15
        ]);
        LevelLimit::create([
            'level' => 4,
            'task' => 300,
            'video' => 1500,
            'partner' => 20,
            'referral' => 25
        ]);
        LevelLimit::create([
            'level' => 5,
            'task' => 500,
            'video' => 2000,
            'partner' => 30,
            'referral' => 40
        ]);
    }
}
