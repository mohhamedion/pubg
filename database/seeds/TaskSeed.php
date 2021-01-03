<?php
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeed extends Seeder
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
            'user_id' => 1,
            'created_by' => 1,
            'active' => 1,
            'moderated' => 1,
            'accepted' => 1,
        ]);

        Task::create([
            'package_name' => 'com.HVRprod.GuessTheFamousPeople',
            'title' => 'Quiz: Guess The Celebrity',
            'keywords' => serialize([ 'угадай звезду']),
            'image_url' => '//lh3.googleusercontent.com/tHJn2u4TrcBx45fKW67tmrZqxsV8e4Hs5f3ACOgNXdReGE9TQuKA5B5MunwEYx6onbo=s180',
            'description' => '',
            'country_group' => 'cis',
            'price' => 30,
            'type' => 1,
            'days' => 10,
            'limit' => 100,
            'time_delay' => 48,
            'top' => 1,
            'country_id' => 219,
            'user_id' => 1,
            'created_by' => 1,
            'active' => 1,
            'moderated' => 1,
            'accepted' => 1,
        ]);

        Task::create([
            'package_name' => 'com.HVRprod.GuessTheLogoFootballQuiz',
            'title' => 'Guess the logo - Football Quiz 2018',
            'keywords' => serialize([ 'угадывать логотипы']),
            'image_url' => '//lh3.googleusercontent.com/2n4C6kQuwU52IcwVT4WRe11sHr4VCa9zU1OHML6nQPqmHg5GkfQEt43faiqAGVXHyV8=s180',
            'description' => '',
            'country_group' => 'cis',
            'price' => 30,
            'type' => 1,
            'days' => 10,
            'limit' => 100,
            'time_delay' => 48,
            'top' => 0,
            'country_id' => 219,
            'user_id' => 1,
            'created_by' => 1,
            'active' => 1,
            'moderated' => 1,
            'accepted' => 1,
        ]);

        Task::create([
            'package_name' => 'com.mlq.crashcar',
            'title' => 'Smash Car',
            'keywords' => serialize([ 'дерби на машинах']),
            'image_url' => '//lh3.googleusercontent.com/YQOR6VvNaArXwuWP-lYo7jCWOVWBtP1FpCi3WRvBoyjmL9nsCK4CCbAOMWXdAK_gVSs=s180',
            'description' => '',
            'country_group' => 'cis',
            'price' => 30,
            'type' => 1,
            'days' => 10,
            'limit' => 100,
            'time_delay' => 24,
            'top' => 1,
            'country_id' => 219,
            'user_id' => 1,
            'created_by' => 1,
            'active' => 1,
            'moderated' => 1,
            'accepted' => 1,
        ]);
        
    }
}
