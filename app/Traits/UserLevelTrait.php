<?php

namespace App\Traits;

use App\Models\RateAward;
use App\Models\User;
use Carbon\Carbon;

trait UserLevelTrait
{
    public function progress(User $user, $key)
    {
        $user_level = $user->level()->first();
        $progress = $user_level->$key;

        $progress[0] += 1;

        $user_level->$key = serialize($progress);

        $user_level->check();
    }

    public function getBonus(User $user, $key)
    {
        $user_level = $user->level()->first();
        $progress = $user_level->$key;

        $level = $progress[2];

        $rate_award = RateAward::all()->find($level);

        $bonus = $rate_award->$key;

        return $bonus;
    }
}
