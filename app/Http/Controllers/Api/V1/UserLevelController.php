<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RateAward;
use App\Models\User;
use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    protected $user;

    private static $hidden_user_level_attributes = [
        'user_id',
        'created_at',
        'updated_at',
    ];

    private static $hidden_rate_award_attributes = [
        'id',
        'level',
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
    }

    /**
     * @SWG\Get(
     *     path="/api/users/level/get",
     *     summary="Get user's level",
     *     tags={"users"},
     *     operationId="Get user's level",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *         @SWG\Schema(
     *             type="object",
     *             required={"info", "rate_award"},
     *             @SWG\Property(
     *                 property="info",
     *                 ref="#/definitions/UserLevel"
     *             ),
     *             @SWG\Property(
     *                 property="rate_award",
     *                 ref="#/definitions/RateAward"
     *             ),
     *             @SWG\Property(
     *                 property="max_rate_award",
     *                 ref="#/definitions/RateAward"
     *             )
     *          )
     *     ),
     * ),
     */
    public function getLevel()
    {
        $info = $this->user->level()->first();
        $info->check();
        $info->makeHidden(self::$hidden_user_level_attributes);

        $rate_award = RateAward::first();

        $rate_award->makeHidden(self::$hidden_rate_award_attributes);

        $rate_award->task = RateAward::whereLevel($info->task[2])->first()->task;

        $rate_award->video = RateAward::whereLevel($info->video[2])->first()->video;

        $rate_award->partner = RateAward::whereLevel($info->partner[2])->first()->partner;

        $rate_award->referral = RateAward::whereLevel($info->referral[2])->first()->referral;

        $max_rate_award = RateAward::find(10);
        $max_rate_award->makeHidden(self::$hidden_rate_award_attributes);

        return response()->json([
            'info' => $info,
            'rate_award' => $rate_award,
            'max_rate_award' => $max_rate_award,
            ], 200);
    }
}
