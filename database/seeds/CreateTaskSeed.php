<?php

use App\Models\Task;
use Illuminate\Database\Seeder;

class CreateTaskSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'package_name' => 'com.HVRprod.FootballQuiz2018',
            'title' => 'Guess The Footballer by Photo - Football Quiz 2018',
            'keywords' => serialize([ 'Угадай футболиста']),
            'image_url' => '//lh3.googleusercontent.com/ef6uCMV2DvUJTOHivM5fT1amYvk8p1OfSjWMlaJUbTeNkdkABWGMpkSyTOlprvMstaQ=s180',
            'description' => '',
            'country_group' => 'cis',
            'price' => 30,
            'type' => 1,
            'days' => 10,
            'limit' => 100,
            'time_delay' => 48,
            'top' => 0,
            'country_id' => 219,
            'other_type' => 1,
            'user_id' => 1,
            'created_by' => 1,
        ]);
    }
}
