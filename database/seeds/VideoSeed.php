<?php

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::query()->delete();
        Video::create([
            'title' => 'Бесплатные рублики',
            'award' => '0',
            'limit' => 20,
            'top' => 1,
            'image_url' => 'admob_logo.png',
            'video_id' => 1,
        ]);
        Video::create([
            'title' => 'Интересные игры',
            'award' => '0',
            'limit' => 10,
            'image_url' => 'adcolony.png',
            'video_id' => 2,
        ]);
        Video::create([
            'title' => 'Крутые приложения',
            'award' => '0',
            'limit' => 10,
            'image_url' => 'fyber-logo.png',
            'video_id' => 3,
        ]);
        Video::create([
            'title' => 'Free coins',
            'award' => '0',
            'limit' => 20,
            'top' => 1,
            'image_url' => 'admob_logo.png',
            'video_id' => 1,
        ]);
        Video::create([
            'title' => 'Hot offers',
            'award' => '0',
            'limit' => 10,
            'image_url' => 'adcolony.png',
            'video_id' => 2,
        ]);
        Video::create([
            'title' => 'Exclusive Offers',
            'award' => '0',
            'limit' => 10,
            'image_url' => 'fyber-logo.png',
            'video_id' => 3,
        ]);
    }
}
