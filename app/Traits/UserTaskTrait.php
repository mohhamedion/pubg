<?php

namespace App\Traits;


use App\Models\Award;
use App\Models\Task;
use App\Models\TaskReview;
use App\Models\User;
use Carbon\Carbon;

trait UserTaskTrait
{

    private static $hidden_task_attributes = [
        'formatted_created_at',
        'price',
        'paid',
        'status',
        'country_id',
        'city_id',
        'price_for_user',
        'install_price',
        'install_price_for_user',
        'top',
        'amount_for_user',
        'amount',
        'limit_state',
        'total_runs',
        'installs_today',
        'time_delay_formatted',
        'expected_price_for_user',
        'user_task_price',
        'amount_wasted',
        //'run_after',
        'review',
        'reviews_moderate',
        'active',
        'done',
        'moderated',
        'accepted',
        'canceled',
        'created_at',
        'updated_at',
        'other_type'
    ];

    private static $hidden_pivot_attributes = [
        'ud',
        'user_id',
        'task_id',
        'is_accepted',
        'is_installed',
        'is_done',
        'date',
        'earned',
        'created_at',
        'updated_at',
    ];

    public function initTasks(User $user)
    {
        $tasks = $user->tasks()->whereIsAccepted(1)->whereIsDone(0)->get()
            ->map(function ($task) use ($user){
                if ($task->pivot->is_accepted == 1 && $task->pivot->is_done == 0) {

                    $time = $task->time_delay;

                    $now = Carbon::now();

                    switch ($task->time_delay) {
                        case 24:
                            $delay = 1;
                            break;
                        case 48:
                            $delay = 2;
                            break;
                        case 72:
                            $delay = 3;
                            break;
                    }

                    $task->pivot->is_available = false;
                    if ($task->pivot->last_open) {
                        if (($time <= $now->diffInHours($task->pivot->last_open) && $time > ($now->diffInHours($task->pivot->last_open) - $time)) || $task->pivot->times == 0) {
                            $task->pivot->is_available = true;
                        } elseif ($now->diffInHours($task->pivot->last_open) > $time) {
                            $cards = unserialize($task->pivot->cards);
                            $progress_bar = unserialize($task->pivot->progress_bar);

                            /*for ($i = 0; $i < count($cards); $i += 1) {
                                if ($cards[$i] == 0) {
                                    $failed = ($now->diffInHours($task->pivot->last_open) - $time) / $time;
                                    $failed = (int) $failed;
                                    for ($a = 0; $a < $failed; $a += 1) {
                                        $cards[$i + $a] = 2;
                                    }
                                    $task->pivot->failed_times += $failed;
                                    if ($progress_bar[1] != 1) {
                                        $progress_bar[0] = (integer) ($i / (count($cards) / 100));
                                        $progress_bar[1] = 1;
                                    }
                                    break;
                                }
                            }*/

                            $failed = ($now->diffInHours($task->pivot->last_open)) / ($time * 2);
                            $failed = (int) $failed;
                            $times = $task->pivot->times + $failed;


                            for ($i = 0; $i < count($cards); $i += 1) {
                                if ($cards[$i] == 0 && $i <= ($times - 1)) {

                                    $count = count($cards);

                                    for ($a = 0; $a < $failed && ($i + $a) < $count; $a++) {
                                        $cards[$i + $a] = 2;
                                    }

                                    $task->pivot->failed_times += $failed;

                                    if ($progress_bar[1] != 1) {
                                        $progress_bar[0] = (integer) ($i / (count($cards) / 100));
                                        $progress_bar[1] = 1;
                                    }
                                    break;
                                }
                            }

                            /*$failed = ($now->diffInHours($task->pivot->last_open)) / ($time * 2);
                            $failed = (int) $failed;
                            $times = $task->pivot->times + $task->pivot->failed_times;


                            for ($i = 0; $i < count($cards); $i += 1) {
                                if ($cards[$i] == 0) {
                                    //$failed = ($now->diffInHours($task->pivot->last_open) - $time) / $time;
                                    $count = count($cards);

                                    for ($a = 0; $a < $failed && ($i + $a) < $count; $a++) {
                                        $cards[$i + $a] = 2;
                                    }

                                    $task->pivot->failed_times += $failed;

                                    if ($progress_bar[1] != 1) {
                                        $progress_bar[0] = (integer) ($i / (count($cards) / 100));
                                        $progress_bar[1] = 1;
                                    }
                                    break;
                                }
                            }*/

                            $task->pivot->cards = serialize($cards);
                            $task->pivot->progress_bar = serialize($progress_bar);

                            if ($task->pivot->times + $task->pivot->failed_times < count($cards)) {
                                $task->pivot->is_available = true;
                            } else {
                                $task->pivot->is_done = 1;
                                $task->pivot->date = Carbon::now()->toDateString();
                                $amount = $task->pivot->times * $task->daily_award;
                                $this->payForReferrer($user, $amount, $task->id);
                                $this->payForDone($user, $task);
                            }
                        }
                    } elseif ($task->pivot->times == 0){
                        $task->pivot->is_available = true;
                    }

                    $task->makeHidden(self::$hidden_task_attributes);
                    $task->pivot->makeHidden(self::$hidden_pivot_attributes);
                    $task->pivot->makeHidden('is_checked');
                    $task->pivot->is_available = (bool)$task->pivot->is_available;

                    if ($task->pivot->is_rating_available == 0 && $task->review()->exists()) {

                        $task->pivot->is_rating_available = $task->pivot->times >= 3 ? 1 : 0;
                        if ($this->user->taskReviews()->exists()) {

                            $review = $this->user->taskReviews()->whereUserTaskUd($task->pivot->ud)->first();
                            switch ($review->state) {
                                case TaskReview::REVIEW_MODERATING:
                                    $task->pivot->is_rating_available = 2;
                                    break;
                                case TaskReview::REVIEW_DONE:
                                    $task->pivot->is_rating_available = 3;
                                    break;
                                case TaskReview::REVIEW_FAILED:
                                    $task->pivot->is_rating_available = 0;
                                    break;
                                case TaskReview::COMMENT_MODERATING:
                                    $task->pivot->is_rating_available = 2;
                                    break;
                                case TaskReview::COMMENT_DONE:
                                    $task->pivot->is_rating_available = 3;
                                    break;
                                case TaskReview::COMMENT_FAILED:
                                    $task->pivot->is_rating_available = 0;
                                    break;
                            }

                        }


                    }

                    $task->pivot->save();


                    return $task;
                }

                return 0;
            })->filter(function ($task) {
                return !!$task;
            });

        return 1;
    }

    public function hiddenAndCards(Task $task, User $user)
    {
        $cards = unserialize($task->pivot->cards);

        $times = $task->pivot->times + $task->pivot->failed_times;

        if ($times == count($cards) &&  $task->pivot->is_done == 0) {
            $task->pivot->is_done = 1;
            $task->pivot->date = Carbon::now()->toDateString();
            $amount = $task->pivot->times * $task->daily_award;
            $this->payForReferrer($user, $amount, $task->id);
            $this->payForDone($user, $task);
        }

        $cards[$times - 1] = 1;

        $progress_bar = unserialize($task->pivot->progress_bar);

        if ($progress_bar[1] != 1) {
            $progress_bar[0] = (integer) ($times / (count($cards) / 100));
        }

        $task->pivot->cards = serialize($cards);
        $task->pivot->progress_bar = serialize($progress_bar);

        $task->pivot->save();

        $task->makeHidden(self::$hidden_task_attributes);
        $task->pivot->makeHidden(self::$hidden_pivot_attributes);
        $task->pivot->makeHidden('is_checked');
        $task->pivot->is_available = (bool) $task->pivot->is_available;
        $task->pivot->progress_bar = unserialize($task->pivot->progress_bar);
        $task->keywords = $task->keywords ? unserialize($task->keywords) : [];

        $i = 0;

        if (count($cards) < 10) {
            $i = count($cards);
            $k = 0;
        } else {

            for ($a = 10; $a <= count($cards); $a += 10) {
                if ($times < $a) {
                    $i = $a;

                    break;
                }
            }

            $k = $i - 10;
        }

        $cards_for_view = [];

        while ($k < $i  && $k < count($cards)) {
            $cards_for_view[] = $cards[$k];
            $k += 1;
        }

        $task->pivot->cards = $cards_for_view;

        return $task;
    }

    public function payForReferrer(User $user, $amount, $id)
    {
        $referrer = $user->referrer()->first();
        if ($referrer) {
            $bonus = $this->getBonus($this->user, 'referral');
            $referrer->referral_balance =  $referrer->referral_balance + ($amount / 100) * $bonus;
            $referrer->balance += ($amount / 100) * $bonus;
            $statistics = $referrer->referralPaid($this->user->id)->first();
            $award = ($amount / 100) * $bonus;
            $statistics->pivot->paid = (float)number_format($statistics->pivot->paid, 2, '.', '') + ($amount / 100) * $bonus;
            $statistics->pivot->save();
            Award::create([
                'referral_system' => 1,
                'amount' => $award,
                'user_id' => $referrer->id,
                'referral_id' => $user->id,
                'application_id' => $id,
            ]);
            $referrer->save();
        }
    }

    public function payForDone(User $user, Task $task)
    {
        $progress_bar = unserialize($task->pivot->progress_bar);
        if ($progress_bar[1] != 1 && $progress_bar[0] == 100) {
            $user->balance += 10;
            $user->save();
        }
    }

    public function countryCis(User $user)
    {
        $cis = [
            219,
            220,
            221,
            222,
            227,
            236,
            280,
            341,
            397,
            407,
            411
        ];

        $first = array_first($cis, function ($value) use ($user) {
            return $value == $user->country_id;
        });

        if ($first) {
            return true;
        } else {
            return false;
        }
    }

}
