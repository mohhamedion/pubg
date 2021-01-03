<?php

namespace App\Traits;

use App\Models\UserLevel;
use App\Models\UserVideo;
use App\Models\User;
use App\Models\UserVideoLimit;
use Carbon\Carbon;

trait UserVideoTrait
{

    private static $hidden_video_attributes = [
        'top',
        'is_available',
        'created_at',
        'updated_at',
    ];

    private static $hidden_pivot_v_attributes = [
        'user_id',
        'video_id',
        'last_open',
        'created_at',
        'updated_at',
    ];


    public function initVideos(User $user)
    {
        $user_limit = $user->videoLimit()->firstOrNew(['limit' => $user->level->video[1]]);

        $time = 24;

        $now = Carbon::now()->toDateString();

        if (is_null($user_limit) || $now !== $user_limit->last_open) {
            $user_limit->today_viewed = 10;
            $user_limit->last_open = Carbon::now()->toDateString();
            $user_limit->save();
        }

        $limit = $user_limit->limit > $user_limit->today_viewed;
        $ru_countries = [219, 220, 221, 222, 397];

        // if (in_array($this->user->country_id, $ru_countries)) {
            // $videos = $user->videos()->where('lang', 'ru');
        // } else {
            // $videos = $user->videos()->where('lang', 'en');
        // }
		
		$videos = $user->videos()->where('lang', 'en');
		
        $videos->get()
            ->map(function ($video) use ($limit, $now) {
                $video->makeHidden(self::$hidden_video_attributes);

                if ($now !== $video->pivot->last_open) {
                    $video->pivot->today_views = 0;
                    $video->pivot->last_open = Carbon::now()->toDateString();
                    $video->pivot->save();
                }

                $video_limit = $video->limit > $video->pivot->today_views;


                $now = Carbon::now();

                if ((($now !== $video->pivot->last_open) || ($video->pivot->views == 0)) && $limit == true && $video_limit) {
                    $video->pivot->is_available = true;
                } else {
                    $video->pivot->is_available = false;
                }

                $video->award = $this->getBonus($this->user, 'video');

                $video->save();

                $video->pivot->save();

                return $video;
            });

    }
}
