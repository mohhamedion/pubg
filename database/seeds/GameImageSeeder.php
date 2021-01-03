<?php

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class GameImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizzes = Game::all();
        foreach ($quizzes as $quiz) {
            $quiz->image = Storage::putFile('public/images', new File(public_path('images/icons/Icon-App-180x180.png')));
            $quiz->save();
        }
    }
}
