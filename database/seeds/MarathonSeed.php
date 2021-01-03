<?php

use App\Models\Marathon;
use App\Models\Task;
use App\Models\Link;
use Illuminate\Database\Seeder;

class MarathonSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marathon::create([
            'title' => 'For beginners',
            'all_days' => 6,
            'current_day' => 1,
            'award' => serialize([5, 5, 5, 5, 5, 10]),
            'type' => 0,
        ]);
        Link::create([
            'text' => 'ВК',
            'link' => 'https://vk.com/thehypegifts',
            'award' => '1.00'
        ]);
    }
}
