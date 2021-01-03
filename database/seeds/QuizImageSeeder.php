<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Quiz;
use Illuminate\Http\File;

class QuizImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizzes = Quiz::all();
        foreach ($quizzes as $quiz) {
            $quiz->image = Storage::putFile('public/images', new File(public_path('images/icons/Icon-App-180x180.png')));
            $quiz->save();
        }
    }
}
