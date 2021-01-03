<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Marathon;
use App\Models\User;
use App\Traits\UserMarathonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SafeController extends Controller
{
    use UserMarathonTrait;

    private const SAFE_STATUS_INACTIVE = 0;
    private const SAFE_STATUS_ACTIVE = 1;
    private const SAFE_STATUS_DONE = 2;

    private $user = null;

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))
            ->first();
        //$this->user = User::whereToken('test1')
        //    ->first();
        if ($this->user) {
            $this->initMarathons($this->user);
        }

    }

    public function progress()
    {
        $user_marathon = $this->user->marathons()
            ->whereDone(0)
            ->first();

        if (empty($user_marathon) && !empty(
            $new_marathon = Marathon::whereNotIn(
                'id',
                $this->user->marathons()
                    ->where('is_active', '=', 1)
                    ->get()
                    ->pluck('id')
            )
                ->first()
            )) {

            $this->user->marathons()
                ->attach($new_marathon->id);
            $this->initMarathons($this->user);
            $user_marathon = $this->user->marathons()
                ->whereDone(0)
                ->first();
        } elseif (empty($user_marathon)) {
            $user_marathon = $this->user->marathons()
                ->whereDone(1)
                ->latest()->get()->first();

            $status = self::SAFE_STATUS_DONE;
        }

        if (empty($user_marathon->pivot->last_open)){
            $flag = true;
        }
        else{
            $flag = (((new \DateTime($user_marathon->pivot->last_open))->getTimestamp() + 24 * 60 * 60) < (new \DateTime(
                ))->getTimestamp()) ;
        }


        if (!isset($status) && $flag) {
            $status = self::SAFE_STATUS_ACTIVE;
        } elseif (!isset($status)) {
            $status = self::SAFE_STATUS_INACTIVE;
        }

        return response()->json(
            [
                'id' => $user_marathon->id,
                'title' => $user_marathon->title,
                'current' => $user_marathon->pivot->user_current_day,
                'max' => $user_marathon->all_days,
                'status' => $status,
                'award' => $user_marathon->award,
            ],
            200
        );
    }

    public function checkpoint(Request $request)
    {
        $safe_loop = false;
        $user_marathon = $this->user->marathons()
            ->whereId($request->get('id'))
            ->first();

        if (!$user_marathon) {
            $this->user->marathons()
                ->attach($request->get('id'));
            $user_marathon = $this->user->marathons()
                ->whereId($request->get('id'))
                ->first();
            $this->initMarathons($this->user);
        }

        if ($user_marathon->pivot->times === $user_marathon->all_days || $user_marathon->pivot->done == 1) {
            $user_marathon->pivot->done = 1;
            $user_marathon->pivot->save();

            if(((new \DateTime($user_marathon->pivot->last_open))->getTimestamp() + 24 * 60 * 60) < (new \DateTime(
                ))->getTimestamp()){
                $user_marathon->pivot->done = 0;

                if (((new \DateTime($user_marathon->pivot->last_open))->getTimestamp() + 24 * 60 * 60 * 2) > (new \DateTime(
                    ))->getTimestamp()) {
                    $safe_loop = true;
                    $user_marathon->pivot->is_available = true;
                    $user_marathon->pivot->times = 5;
                    $user_marathon->pivot->user_current_day = 6;
                } else {
                    $user_marathon->pivot->is_available = true;
                    $user_marathon->pivot->times = 0;
                    $user_marathon->pivot->user_current_day = 1;
                }
                $user_marathon->pivot->save();
            }
            else{
                return response()->json(null, 467);
            }
        }

        if ($user_marathon->pivot->is_available == 0) {
            return response()->json($this->user->balance, 200);
        }

        $user_marathon->pivot->times += 1;
        if ($user_marathon->pivot->last_open) {
            $user_marathon->pivot->last_open = Carbon::instance(new \DateTime($user_marathon->pivot->last_open))->addDay()
                ->toDateString();
        } else {
            $user_marathon->pivot->last_open = Carbon::now()
                ->toDateString();
        }
        if ($user_marathon->pivot->times === $user_marathon->all_days && !$safe_loop) {
            $user_marathon->pivot->done = 1;
        }

        $user_marathon->pivot->save();

        if ($user_marathon->type == 0) {
            $this->user->balance += $user_marathon->award[$user_marathon->pivot->user_current_day - 1];
        } else {
            $this->user->balance += $user_marathon->award[$user_marathon->current_day - 1];
        }

        $this->user->save();

        return response()->json($this->user->balance, 200);
    }
}
