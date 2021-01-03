<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Settings;
use App\Models\Task;
use App\Models\User;
use App\Models\Video;
use App\Models\Partner;
use App\Models\Referral;
use App\Traits\UserLevelTrait;
use App\Traits\UserTaskTrait;
use App\Traits\UserVideoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class TaskController extends Controller
{
    use UserTaskTrait;
    use UserVideoTrait;
    use UserLevelTrait;

    protected $user;

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

    private static $hidden_history_task_attributes = [
        'formatted_created_at',
        'price',
        'package_name',
        'paid',
        'status',
        'country_id',
        'city_id',
        'price_for_user',
        'amount_for_user',
        'amount',
        'limit_state',
        'total_runs',
        'installs_today',
        'time_delay_formatted',
        'expected_price_for_user',
        'user_task_price',
        'award',
        'type',
        'days',
        'time_delay',
        'keywords',
        'daily_award',
        'top',
        'amount',
        'amount_wasted',
        'review',
        'active',
        'done',
        'moderated',
        'accepted',
        'canceled',
        'created_at',
        'updated_at',
        'other_type',
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

    private static $hidden_history_pivot_attributes = [
        'user_id',
        'task_id',
        'is_checked',
        'times',
        'failed_times',
        'is_available',
        'is_accepted',
        'is_done',
        'cards',
        'progress_bar',
        'created_at',
        'updated_at',
    ];

    private static $hidden_partner_attributes = [
        'top',
        'is_available',
        'image_url',
        'created_at',
        'updated_at',
    ];

    private static $hidden_pivot_p_attributes = [
        'user_id',
        'partner_id',
        'created_at',
        'updated_at',
    ];

    private static $hidden_referral_attributes = [
        'id',
        'created_at',
        'updated_at',
    ];

    private static $hidden_link_attributes = [
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
        if ($this->user) {
            $this->initTasks($this->user);
        }
        $tasks = Task::whereDone(0)->active()->whereOtherType(0)
            ->get()
            ->map(function ($task) {
                $users = $task->users()->wherePivot('is_accepted', 1)->count();
                $keywords = $task->keywords;
                $keywords = $keywords ? true : false;

                if ($keywords) {
                    $task->type = 1;
                }

                if ($users == $task->limit) {
                    $task->done = 1;
                    $task->active = 0;
                }

                $task->save();

                return $task;
            });
    }

    public function tasksTop()
    {
        $user_tasks = $this->user->tasks()->whereTop(1)->active()->whereIsDone(0)->whereIsAccepted(1)->get();
        $user_tasks_ids = $user_tasks->pluck('id');

        $user_done_tasks = $this->user->tasks()->whereTop(1)->whereIsDone(1)->get();
        $user_done_tasks_ids = $user_done_tasks->pluck('id');

        if ($this->countryCis($this->user)) {
            $tasks = Task::whereNotIn('id', $user_done_tasks_ids)
                ->whereCountryId($this->user->country_id)
                ->whereOtherType(0)->whereTop(1)->whereDone(0)->active()
                ->get()
                ->map(function ($task) use ($user_tasks_ids, $user_done_tasks_ids) {

                    $first = array_first($user_tasks_ids, function ($value) use ($task) {
                        return $value == $task->id;
                    });
                    if ($first) {
                        $task = $this->user->tasks()->find($task->id);
                        $task = $this->hiddenAndCards($task, $this->user);
                    } else {
                        $keywords = $task->keywords;
                        $task->keywords = $keywords ? unserialize($keywords) : [];
                        $today = Carbon::now()->toDateString();

                        if ($task->daily_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit) {
                                return 0;
                            }
                        }

                        if ($task->hourly_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->where('created_at', '<', Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit) {
                                return 0;
                            }
                        }
                    }

                    $task->makeHidden(self::$hidden_task_attributes);

                    return $task;
                })->filter(function ($task) {
                    return !!$task;
                })->toArray();

            $tasks_null = Task::whereNotIn('id', $user_done_tasks_ids)
                ->whereCountryId(null)
                ->whereOtherType(0)->whereTop(1)->whereDone(0)->active()
                ->get()
                ->map(function ($task) use ($user_tasks_ids, $user_done_tasks_ids) {

                    $first = array_first($user_tasks_ids, function ($value) use ($task) {
                        return $value == $task->id;
                    });
                    if ($first) {
                        $task = $this->user->tasks()->find($task->id);
                        $task = $this->hiddenAndCards($task, $this->user);
                    } else {
                        $keywords = $task->keywords;
                        $task->keywords = $keywords ? unserialize($keywords) : [];
                        $today = Carbon::now()->toDateString();
                        $now = Carbon::now();

                        if ($task->daily_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit) {
                                return 0;
                            }
                        }

                        if ($task->hourly_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->where('created_at', '<', Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit) {
                                return 0;
                            }
                        }
                    }

                    $task->makeHidden(self::$hidden_task_attributes);

                    return $task;
                })->filter(function ($task) {
                    return !!$task;
                })->toArray();

            $tasks = array_merge($tasks, $tasks_null);

            $count = Task::whereNotIn('id', $user_done_tasks_ids)->whereCountryId($this->user->country_id)
                ->whereOtherType(0)->whereTop(1)->whereDone(0)->active()->count()
            + Task::whereNotIn('id', $user_done_tasks_ids)->whereCountryId(null)
                    ->whereOtherType(0)->whereTop(1)->whereDone(0)->active()->count();


            if ($count == 0) {
                $task = Task::find(1);
                $keywords = $task->keywords;
                $task->keywords = $keywords ? unserialize($keywords) : [];

                $tasks[] = $task->makeHidden(self::$hidden_task_attributes);
            }
        } else {
            $tasks = [];
        }

        $rate = Settings::first()->rate;

        //getting the links
        $countriesIds = [
            219,
            221,
            222,
        ];

        $key = $this->user->country_id;
        $first = array_first($countriesIds, function ($value) use ($key){
            return $value == $key;
        });

        $user_links = $this->user->links();
        $linkIds = $user_links->pluck('id');

        if ($first) {

            $links = Link::all()
                ->map(function ($link) use ($rate, $linkIds){

                    $first = array_first($linkIds, function ($value) use ($link) {
                        return $value == $link->id;
                    });

                    if ($first) {
                        $link->award = 0;
                    } else {
                        $link->award = $link->award * $rate;
                    }

                    $link->makeHidden(self::$hidden_link_attributes);

                    return $link;
                });
        } else {

            $notAvIds = [1];
            $links = Link::whereNotIn('id', $notAvIds)
                ->get()
                ->map(function ($link) use ($rate, $linkIds){

                    $first = array_first($linkIds, function ($value) use ($link) {
                        return $value == $link->id;
                    });

                    if ($first) {
                        $link->award = 0;
                    } else {
                        $link->award = $link->award * $rate;
                    }

                    $link->makeHidden(self::$hidden_link_attributes);


                    return $link;
                });
        }

        //getting the referral
        $referral = Referral::first();
        $referral->makeHidden(self::$hidden_referral_attributes);

        //getting the partners
        $partners = Partner::whereTop(1)->get();
        $user_partners = $this->user->partners()->get();
        $partnerIds = $user_partners->pluck('id');

        foreach ($partners as $partner) {
            $first = array_first($partnerIds, function ($value) use ($partner) {
                return $value == $partner->id;
            });
            if ($first) {
                continue;
            } else {
                $this->user->partners()->attach($partner->id);
            }
        }

        $partners = $this->user->partners()->whereIsAvailable(1)->whereTop(1)
            ->get()
            ->map(function ($partner) {
                $partner->makeHidden(self::$hidden_partner_attributes);
                $partner->award = $this->getBonus($this->user, 'partner');

                $partner->pivot->earned = (float)number_format($partner->pivot->earned, 2, '.', '');
                $partner->pivot->makeHidden(self::$hidden_pivot_p_attributes);

                return $partner;
            });

        //getting the videos
        $videos = Video::whereTop(1)->get();
        $user_videos = $this->user->videos()->get();
        $videoIds = $user_videos->pluck('id');

        foreach ($videos as $video) {
            $first = array_first($videoIds, function ($value) use ($video) {
                return $value == $video->id;
            });
            if ($first) {
                continue;
            } else {
                $this->user->videos()->attach($video->id);
            }
        }

        $this->initVideos($this->user);

        $videos = $this->user->videos()->whereAvailable(1)->whereTop(1)
            ->get()
            ->map(function ($video) {
                $video->makeHidden(self::$hidden_video_attributes);

                $video->pivot->is_available = (bool)$video->pivot->is_available;
                $video->pivot->earned = (float)number_format($video->pivot->earned, 2, '.', '');
                $video->pivot->makeHidden(self::$hidden_pivot_v_attributes);

                return $video;
            });

        $balance = [
            'description' => "Баланс",
        ];

        $entertainment = [
            'description' => "Развлечения"
        ];

        return response()->json([
            'tasks' => $tasks,
            'links' => $links,
            'referral' => $referral,
            'partners' => $partners,
            'videos' => $videos,
            'balance' => $balance,
            'entertainment' => $entertainment,
        ], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/tasks/new",
     *     summary="Get new tasks",
     *     tags={"tasks"},
     *     operationId="Get new tasks",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit of task",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation, tasks array provided",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Task")
     *         )
     *     ),
     * ),
     */
    public function newTasks(Request $request)
    {
        // if (!$this->countryCis($this->user)) {
            // $tasks = [];

            // return response()->json($tasks, 200);
        // }

            // get accepted tasks
        $user_tasks = $this->user->tasks()->active()->whereIsAccepted(1)
            ->get()
            ->map(function ($task) {
                $task->makeHidden(self::$hidden_task_attributes);
                return $task;
            });

        $user_checked_tasks = $this->user->tasks()->active()->whereIsChecked(1)
            ->get()
            ->map(function ($task) {
                $task->makeHidden(self::$hidden_task_attributes);
                return $task;
            });
			
		//$user_checked_tasks = array();
	
        // if tasks array is not empty
        if ($user_tasks->isNotEmpty() || $user_checked_tasks->isNotEmpty()) {

            // get theirs ids
            $taskIds = $user_tasks->pluck('id');
            // get only not accepted tasks
            $user_checked_tasks = $this->user->tasks()
                ->whereNotIn('id', $taskIds)
                ->get();
            $checkedTaskIds = $user_checked_tasks->pluck('id');
            //$tasks = Task::whereOtherType(0)->whereCountryId($this->user->country_id)
            $tasks = Task::whereOtherType(0)
                ->orderBy('top','DESC')->whereDone(0)->active()
                ->whereNotIn('id', $taskIds)
                ->limit(empty($request->get('limit'))?Task::all()->count():$request->get('limit'))
                ->offset(empty($request->get('offset'))?0:$request->get('offset'))
                ->get()
                ->map(function ($task) use ($checkedTaskIds) {
                    $key = $task->id;
                    if ($first = array_first($checkedTaskIds, function ($value) use ($key) {
                        return $value == $key;
                    })) {
                        $task = $this->user->tasks()->find($first);
                        $task->pivot->makeHidden(self::$hidden_pivot_attributes);
                        $task->pivot->is_available = (boolean) $task->pivot->is_available;
                        $task->pivot->is_checked = (boolean) $task->pivot->is_checked;
                    } else {
                        $today = Carbon::now()->toDateString();

                        if ($task->daily_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit) {
                                return 0;
                            }
                        }

                        if ($task->hourly_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->where('created_at', '<', Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit) {
                                return 0;
                            }
                        }
                    }

                    $keywords = $task->keywords;
                    $task->keywords = $keywords ? unserialize($keywords) : [];
                    $task->makeHidden(self::$hidden_task_attributes);

                    return $task;
                })->filter(function ($task) {
                    return !!$task;
                })
                ->toArray();
				
			return response()->json($tasks, 200);
			
            $tasks_null = Task::whereOtherType(0)->whereCountryId(null)
                ->orderBy('top','DESC')->whereDone(0)->active()
                ->whereNotIn('id', $taskIds)
                ->limit(empty($request->get('limit'))?Task::all()->count():$request->get('limit'))
                ->offset(empty($request->get('offset'))?0:$request->get('offset'))
                ->get()
                ->map(function ($task) use ($checkedTaskIds) {
                    $key = $task->id;
                    if ($first = array_first($checkedTaskIds, function ($value) use ($key) {
                        return $value == $key;
                    })) {
                        $task = $this->user->tasks()->find($first);
                        $task->pivot->makeHidden(self::$hidden_pivot_attributes);
                        $task->pivot->is_available = (boolean) $task->pivot->is_available;
                        $task->pivot->is_checked = (boolean) $task->pivot->is_checked;
                    } else {
                        $today = Carbon::now()->toDateString();

                        if ($task->daily_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit) {
                                return 0;
                            }
                        }

                        if ($task->hourly_budget) {
                            if ($task->tasks()->whereIsAccepted(1)->where('created_at', '<', Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit) {
                                return 0;
                            }
                        }
                    }

                    $keywords = $task->keywords;
                    $task->keywords = $keywords ? unserialize($keywords) : [];
                    $task->makeHidden(self::$hidden_task_attributes);

                    return $task;
                })->filter(function ($task) {
                    return !!$task;
                })
                ->toArray();

            $tasks = array_merge($tasks, $tasks_null);

            return response()->json($tasks, 200);
        }

        // get only not checked tasks
        $notCheckedTasks = Task::query()
            ->whereOtherType(0)->orderBy('top','DESC')->whereDone(0)->active()
            ->limit(empty($request->get('limit'))?Task::all()->count():$request->get('limit'))
            ->offset(empty($request->get('offset'))?0:$request->get('offset'))
            ->get()
            ->map(function ($task) {
                $task->makeHidden(self::$hidden_task_attributes);
                $keywords = $task->keywords;
                $task->keywords = $keywords ? unserialize($keywords) : [];
                $today = Carbon::now()->toDateString();

                if ($task->daily_budget) {
                    if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit) {
                        return 0;
                    }
                }

                if ($task->hourly_budget) {
                    if ($task->tasks()->whereIsAccepted(1)->where('created_at', '<', Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit) {
                        return 0;
                    }
                }

                return $task;
            })->filter(function ($task) {
                return !!$task;
            })
            ->toArray();

        $notCheckedTasks_null = Task::query()->whereCountryId(null)
            ->whereOtherType(0)->orderBy('top','DESC')->whereDone(0)->active()
            ->limit(empty($request->get('limit'))?Task::all()->count():$request->get('limit'))
            ->offset(empty($request->get('offset'))?0:$request->get('offset'))
            ->get()
            ->map(function ($task) {
                $task->makeHidden(self::$hidden_task_attributes);
                $keywords = $task->keywords;
                $task->keywords = $keywords ? unserialize($keywords) : [];
                $today = Carbon::now()->toDateString();

                if ($task->daily_budget) {
                    if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit) {
                        return 0;
                    }
                }

                if ($task->hourly_budget) {
                    if ($task->tasks()->whereIsAccepted(1)->where('created_at', '<', Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit) {
                        return 0;
                    }
                }

                return $task;
            })->filter(function ($task) {
                return !!$task;
            })
            ->toArray();

        //$notCheckedTasks = array_merge($notCheckedTasks, $notCheckedTasks_null);
        //$notCheckedTasks = $notCheckedTasks;

        return response()->json($notCheckedTasks, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/tasks/check",
     *     summary="Mark task as checked",
     *     tags={"tasks"},
     *     operationId="Mark task as checked",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="query",
     *         description="id of task",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     * ),
     */

    public function checkedTask(Request $request)
    {
        $task = Task::find($request->get('task_id'));

        if ($this->user->tasks()->find($request->get('task_id')))
            return response()->json(null, 200);

        $this->user->tasks()->attach($task->id);

        return response()->json(null, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/tasks/install",
     *     summary="Mark task as installed",
     *     tags={"tasks"},
     *     operationId="Mark task as installed",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="query",
     *         description="id of task",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     * ),
     */

    public function installedTask(Request $request)
    {
        $task = Task::find($request->get('task_id'));

        if (!($user_task = $this->user->tasks()->find($request->get('task_id')))) {
            $this->user->tasks()->attach($task->id);
            $user_task = $this->user->tasks()->find($request->get('task_id'));
        }

        if ($user_task->pivot->is_installed) {
            return response()->json(null, 200);
        }

        $user_task->pivot->is_installed = 1;
        $user_task->pivot->save();

        if ($user_task->install_price > 0) {
            $rate = Settings::first()->rate;

            $this->user->balance += $user_task->install_price * $rate;
            $this->user->logAward($user_task->install_price * $rate, null, $task->id);
            $this->user->save();
        }

        return response()->json(null, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/tasks/update",
     *     summary="Update the task",
     *     tags={"tasks"},
     *     operationId="Update the task",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="task_id",
     *         in="query",
     *         description="id of task",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *         @SWG\Schema(ref="#/definitions/Users_Task")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Task already has been done",
     *     ),
     *     @SWG\Response(
     *         response=410,
     *         description="Task is not available",
     *     ),
     * ),
     */
    public function updateTask(Request $request)
    {
        $this->initTasks($this->user);

        $task = $this->user->tasks()->find($request->get('task_id'));

        if ($task) {
            if ($task->pivot->is_available == 0) {
                $task = $this->hiddenAndCards($task, $this->user);

                return response()->json($task, 410);
            }

            if ($task->pivot->is_done == 1) {
                $task = $this->hiddenAndCards($task, $this->user);

                return response()->json($task, 401);
            }

            if ($task->pivot->is_accepted == 0) {
                $task->pivot->is_accepted = 1;

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

                $cards = array_fill(0, $task->days / $delay, 0);
                $progress_bar = array_fill(0, 2, 0);
                $task->pivot->cards = serialize($cards);
                $task->pivot->progress_bar = serialize($progress_bar);

            }
        } elseif ($task = Task::find($request->get('task_id'))) {

            $today = Carbon::now()->toDateString();

            if ($task->tasks()->whereIsAccepted(1)->whereDate('created_at', '=', $today)->count() >= $task->daily_budget_installs_limit &&
                $task->tasks()->whereIsAccepted(1)->where('created_at', '<',Carbon::parse('-1 hours'))->count() >= $task->hourly_budget_installs_limit
            ) {
                return response()->json(null, 410);
            }

            $this->user->tasks()->attach($request->get('task_id'));
            $task = $this->user->tasks()->whereId($request->get('task_id'))->first();
            $task->pivot->is_checked = 1;
            $task->pivot->is_accepted = 1;

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

            $cards = array_fill(0, $task->days / $delay, 0);
            $progress_bar = array_fill(0, 2, 0);
            $task->pivot->cards = serialize($cards);
            $task->pivot->progress_bar = serialize($progress_bar);


        }

        $task->pivot->times += 1;
        $task->pivot->last_open = Carbon::now()->toDateTimeString();

        $times = $task->pivot->times + $task->pivot->failed_times;
        $cards = unserialize($task->pivot->cards);

        if ($times == count($cards)) {
            $task->pivot->is_done = 1;
            $task->pivot->date = Carbon::now()->toDateString();
            $amount = $task->pivot->times * $task->daily_award;
            $this->payForReferrer($this->user, $amount, $task->id);
            $this->payForDone($this->user, $task);
        }


        $cards[$times - 1] = 1;

        $progress_bar = unserialize($task->pivot->progress_bar);

        if ($progress_bar[1] != 1) {
            $progress_bar[0] = (int) ($times / (count($cards) / 100));
        }

        $task->pivot->cards = serialize($cards);
        $task->pivot->progress_bar = serialize($progress_bar);
        $task->pivot->earned = ((float) number_format($task->pivot->earned, 2, '.', '')) + $task->daily_award;

        $task->pivot->save();

        $this->initTasks($this->user);

        $task = $this->user->tasks()->find($request->get('task_id'));

        $task->makeHidden(self::$hidden_task_attributes);
        $task->pivot->makeHidden(self::$hidden_pivot_attributes);
        $task->pivot->makeHidden('is_checked');
        $task->pivot->is_available = (bool) 0;//$task->pivot->is_available;
        $task->pivot->progress_bar = [];

        if (!empty($task->deferred_start)){
            $task->available_time = $task->deferred_start;
        }else{
            $task->available_time = (new \DateTime($task->pivot->last_open . ' +' . $task->time_delay . "hour"))->format('Y-m-d H:d:s');
        }

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
        $keywords = $task->keywords;
        $task->keywords = $keywords ? unserialize($keywords) : [];

        $bonus = $this->getBonus($this->user, 'task');
        $this->progress($this->user, 'task');
        $this->user->balance += $task->daily_award + $bonus;
        $this->user->logAward($task->daily_award + $bonus, null, $task->id);

        $this->user->save();

        return response()->json($task, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/tasks/get",
     *     summary="Get user's tasks",
     *     tags={"tasks"},
     *     operationId="Get user's tasks",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation, tasks array provided",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Users_Task")
     *         )
     *     ),
     * ),
     */
    public function getTasks()
    {
        $this->initTasks($this->user);

        $available_tasks = $this->user->tasks()->wherePivot('is_accepted', true)->wherePivot('is_done', false)->wherePivot('is_available', true)->get()
            ->map(function ($task) {

                $task->makeHidden(self::$hidden_task_attributes);
                $task->pivot->makeHidden(self::$hidden_pivot_attributes);
                $task->pivot->makeHidden('is_checked');
                $task->pivot->is_available = (bool)$task->pivot->is_available;
                $task->pivot->progress_bar = [];//(array) unserialize($task->pivot->progress_bar);
                $cards = unserialize($task->pivot->cards);


                $times = $task->pivot->times + $task->pivot->failed_times;

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

                if ($k >= 0) {

                    while ($k < $i  && $k < count($cards)) {
                        $cards_for_view[] = $cards[$k];
                        $k += 1;
                    }

                } else {
                    $cards_for_view = null;
                }

                $task->pivot->cards = $cards_for_view;
                $keywords = $task->keywords;
                $task->keywords = $keywords ? unserialize($keywords) : [];

                if (!empty($task->deferred_start)){
                    $task->available_time = $task->deferred_start;
                }else{
                    $task->available_time = (new \DateTime($task->pivot->last_open . ' +' . $task->time_delay . "hour"))->format('Y-m-d H:d:s');
                }

                return $task;
            })->toArray();

        $other_tasks = $this->user->tasks()->wherePivot('is_accepted', true)->wherePivot('is_done', false)->wherePivot('is_available', false)->get()
            ->map(function ($task) {

                $task->makeHidden(self::$hidden_task_attributes);
                $task->pivot->makeHidden(self::$hidden_pivot_attributes);
                $task->pivot->makeHidden('is_checked');
                $task->pivot->is_available = (bool)$task->pivot->is_available;
                $task->pivot->cards = unserialize($task->pivot->cards);
                $task->pivot->progress_bar = [];
                $keywords = $task->keywords;
                $task->keywords = $keywords ? unserialize($keywords) : [];

                if (!empty($task->deferred_start)){
                    $task->available_time = $task->deferred_start;
                }else{
                    $task->available_time = (new \DateTime($task->pivot->last_open . ' +' . $task->time_delay . "hour"))->format('Y-m-d H:d:s');
                }

                return $task;
            })->toArray();

        $tasks = array_merge($available_tasks, $other_tasks);

        return response()->json($tasks, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/tasks/history",
     *     summary="Get user's task history",
     *     tags={"tasks"},
     *     operationId="Get user's task history",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *      @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation, tasks array provided",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/HistoryTask")
     *         )
     *     ),
     * ),
     */
    public function history(Request $request)
    {
        $history = $this->user->tasks()->whereIsDone(1)
            ->limit($request->get('limit'))
            ->offset($request->get('offset'))
            ->get()
            ->map(function ($task) {
                $task->makeHidden(self::$hidden_history_task_attributes);
                $task->pivot->makeHidden(self::$hidden_history_pivot_attributes);
                $task->pivot->earned = (float)number_format($task->pivot->earned, 2, '.', '');

                return $task;
            });

        return response()->json($history, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/links/award",
     *     summary="Get award for link",
     *     tags={"tasks"},
     *     operationId="Get award for link",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="link_id",
     *         in="query",
     *         description="link_id",
     *         required=true,
     *         type="string",
     *     ),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful operation, tasks array provided",
     *     ),
     *     @SWG\Response(
     *         response=489,
     *         description="Award has been got already",
     *     ),
     * ),
     */
    public function getLinkAward(Request $request)
    {
        $link = Link::find($request->get('link_id'));

        $user_link = $this->user->links()->whereId($request->get('link_id'))->first();

        if ($user_link) {
            return response()->json(null, 489);
        }

        $this->user->links()->attach($request->get('link_id'));
        $rate = Settings::first()->rate;
        $this->user->balance += $link->award * $rate;
        $this->user->save();

        return response()->json(null, 200);
    }
}
