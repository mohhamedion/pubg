<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Marathon;
use App\Models\User;
use App\Traits\UserMarathonTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MarathonController extends Controller
{
    use UserMarathonTrait;

    protected $user;

    private static $hidden_marathon_attributes = [
        'type',
        'is_active',
        'created_at',
        'updated_at',
        'is_available',
    ];

    private static $hidden_pivot_attributes = [
        'user_id',
        'marathon_id',
        'last_open',
        'user_current_day',
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
        if ($this->user) {
            $this->initMarathons($this->user);
        }
    }


    public function event()
    {
        $user_marathons = $this->user->marathons()
            ->get()
            ->map(function ($marathon) {
                $marathon->makeHidden(self::$hidden_marathon_attributes);
                $marathon->pivot->failed = (bool) $marathon->pivot->failed;
                $marathon->pivot->is_available = (bool) $marathon->pivot->is_available;
                $marathon->pivot->done = (bool) $marathon->pivot->done;
                $marathon->pivot->makeHidden(self::$hidden_pivot_attributes);

                if ($marathon->pivot->user_current_day) {
                    $marathon->current_day = $marathon->pivot->user_current_day;
                } else {
                    if ($marathon->type == 0) {
                        $marathon->current_day = 1;
                        $marathon->pivot->user_current_day = $marathon->current_day;
                    }
                }

                return $marathon;
            });

        if($user_marathons->isNotEmpty()){

            $marathonIds = $user_marathons->pluck('id');
            $notUserMarathons = Marathon::whereNotIn('id', $marathonIds)
                ->get()
                ->map(function ($notUserMarathon) {
                    $notUserMarathon->makeHidden(self::$hidden_marathon_attributes);
                    return $notUserMarathon;
                });

            return response()->json([
                'user_marathons' => $user_marathons,
                'marathons' => $notUserMarathons,
            ], 200);
        }

        $user_marathons = $this->user->marathons()->whereDone(1)->get()
            ->map(function ($marathon) {
            $marathon->makeHidden(self::$hidden_marathon_attributes);
            $marathon->pivot->failed = (bool) $marathon->pivot->failed;
            $marathon->pivot->is_available = (bool) $marathon->pivot->is_available;
            $marathon->pivot->done = (bool) $marathon->pivot->done;
            $marathon->pivot->makeHidden(self::$hidden_pivot_attributes);

            if ($marathon->pivot->user_current_day && $marathon->type == 0) {
                $marathon->current_day = $marathon->pivot->user_current_day;
            } elseif ($marathon->type == 0)  {
                $marathon->current_day = 1;
                $marathon->pivot->user_current_day = $marathon->current_day;
            }


            return $marathon;
        });

        $marathonIds = $user_marathons->pluck('id');
        $notUserMarathons = Marathon::whereNotIn('id', $marathonIds)
            ->get()
            ->map(function ($notUserMarathon) {
                $notUserMarathon->makeHidden(self::$hidden_marathon_attributes);
                return $notUserMarathon;
            });

        return response()->json([
            'marathons' => $notUserMarathons
        ], 200);
    }


    public function checkpoint(Request $request)
    {
        $user_marathon = $this->user->marathons()->whereId($request->get('id'))->first();

        if($user_marathon->pivot->times === $user_marathon->all_days){
            $user_marathon->pivot->done = 1;
            $user_marathon->pivot->save();

            return response()->json(null, 467);
        }

        if ($user_marathon->pivot->done == 1) {
            return response()->json(null, 467);
        }
        
        if(!$user_marathon){
            $this->user->marathons()->attach($request->get('id'));
            $user_marathon = $this->user->marathons()->whereId($request->get('id'))->first();
            $this->initMarathons($this->user);
        }

        if ($user_marathon->pivot->is_available == 0) {
            return response()->json($this->user->balance, 200);
        }

        $user_marathon->pivot->times += 1;

        if ($user_marathon->pivot->times == $user_marathon->all_days) {
            $user_marathon->pivot->done = 1;
        }

        $user_marathon->pivot->last_open = Carbon::now()->toDateString();

        if($user_marathon->pivot->times === $user_marathon->all_days){
            $user_marathon->pivot->done = 1;
        }
        $user_marathon->pivot->save();

        if ($user_marathon->type == 0) {
            $this->user->balance += $user_marathon->award[$user_marathon->pivot->user_current_day - 1];
        } else {
            $this->user->balance += $user_marathon->award[$user_marathon->current_day - 1];
        }

        $this->user->save();

        return response()->json((integer) $this->user->balance, 200);
    }
}
