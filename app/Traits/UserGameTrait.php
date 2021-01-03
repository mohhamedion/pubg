<?php

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;

trait UserGameTrait
{
    public function initGames(User $user)
    {
        $user_limits = $user->games()->get();

        $now = Carbon::now()->toDateString();
        foreach ($user_limits as $user_limit) {

            if ($now !== $user_limit->pivot->last_open) {
                $user_limit->pivot->today_times = 0;
                $user_limit->pivot->today_earned = 0;
                $user_limit->pivot->last_open = Carbon::now()->toDateString();
                $user_limit->pivot->save();
            }
//            $limit = $user_limit->pivot->limit > $user_limit->pivot->today_times;
            if ($user_limit->pivot->today_earned < 10) {
                $user_limit->pivot->is_available = true;
            } else {
                $user_limit->pivot->is_available = false;
            }

            $user_limit->pivot->save();
        }
    }
}
