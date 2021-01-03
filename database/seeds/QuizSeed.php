<?php

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quiz::create([
            'title' => 'Общие',
            'offset' => 1,
        ]);
        Quiz::create([
            'title' => 'Наука',
            'offset' => 16,
        ]);
        Quiz::create([
            'title' => 'Компьютерные игры',
            'offset' => 31,
        ]);
        Quiz::create([
            'title' => 'Техника',
            'offset' => 46,
        ]);
        Quiz::create([
            'title' => 'Спорт',
            'offset' => 61,
        ]);
    }
}
