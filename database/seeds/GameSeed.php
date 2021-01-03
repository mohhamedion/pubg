<?php

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::create([
            'title' => 'Gang Bang',
        ]);
    }
}
