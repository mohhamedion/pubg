<?php

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;

trait UserMarathonTrait
{


    public function initMarathons(User $user)
    {
        $user->marathons()
            ->get()
            ->map(function ($marathon) {
                $marathon->pivot->failed = (bool) $marathon->pivot->failed;

                if($marathon->pivot->times === $marathon->all_days){
                    $marathon->pivot->done = 1;
                    if (((new \DateTime($marathon->pivot->last_open))->getTimestamp() + 24 * 60 * 60 * 2) < (new \DateTime(
                        ))->getTimestamp()) {
                        $marathon->pivot->done = 0;
                    }
                }

                $now = Carbon::now()->toDateString();
                $marathon->pivot->is_available = false;

                if ($marathon->pivot->last_open && !($marathon->pivot->done)) {

                    if (($now !== $marathon->pivot->last_open) && !($marathon->pivot->failed)) {
                        $marathon->pivot->is_available = true;
                        if ($marathon->type == 0) {
                            if ($marathon->pivot->times < 6) {
                                $marathon->current_day = $marathon->pivot->times + 1;
                            } else {
                                $marathon->current_day = $marathon->pivot->times;
                            }
                            $marathon->pivot->user_current_day = $marathon->current_day;
                        }
                    } else {
                        if ($marathon->type == 0) {
                            $marathon->current_day = $marathon->pivot->user_current_day;
                        }
                    }
                } elseif ($marathon->pivot->times == 0) {
                    $marathon->pivot->is_available = true;
                    if ($marathon->type == 0) {
                        $marathon->current_day = 1;
                        $marathon->pivot->user_current_day = $marathon->current_day;
                    }
                }

                $marathon->pivot->save();
            });
    }
}
