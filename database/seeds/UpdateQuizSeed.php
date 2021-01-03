<?php

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class UpdateQuizSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quiz::where('id', 1)->first()->update([
            'title' => 'История',
            'offset' => 1,
        ]);
        Quiz::where('id', 2)->first()->update([
            'title' => 'Общие',
            'offset' => 16,
        ]);
    }
}
