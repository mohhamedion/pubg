<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\LevelLimit;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use GeoIP;

class ApiController extends Controller
{

    public function getToken(Request $request): JsonResponse
    {
        $response = function ($user) {
            return response()->json([
                'token' => $user->token,
                'promo_code_first' => $user->promo_code_first,
                'promo_code_second' => $user->promo_code_second,
            ], 200);
        };

        $user = User::whereEmail($request->get('email'))->first();
        if ($user) {

            return $response($user);
        } else {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'token' => str_random(),
                'promo_code_first' => str_random(),
                'promo_code_second' => str_random(),
            ]);

            $user->marathons()->attach(1);

            $user->roles()->attach(Role::USER_ROLE_ID);

            $limit = LevelLimit::whereLevel(1)->first();

            $user->level()->create([
                'task' => serialize([0, $limit->task, 1, 3]),
                'video' => serialize([0, $limit->video, 1, 3]),
                'partner' => serialize([0, $limit->partner, 1, 3]),
                'referral' => serialize([0, $limit->referral, 1, 3]),
            ]);

            $user->videoLimit()->create([
                'limit' => 100,
                'last_open' => Carbon::now()->toDateString(),
            ]);

            for ($i = 1; $i < 6; $i++) {
                $user->quizzes()->attach($i);
            }

            if (Country::whereId($request->get('country_id'))->first()) {
                $country = Country::whereId($request->get('country_id'))->first();
                $user->country_id = $country->id;
            } else {
                $user->country_id = 219;
            }

            /*$quizzes = $user->quizzes()->get()->map(function ($quiz) {
                $quiz->pivot->last_open = Carbon::now()->toDateString();
                $quiz->pivot->save();

                return $quiz;
            });*/


            $user->save();

            return $response($user);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/delete",
     *     summary="Delete a user",
     *     tags={"users"},
     *     operationId="Delete a user",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="query",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *
     *     ),
     * ),
     */
    public function delete(Request $request)
    {
        $user = User::whereToken($request->get('token'))->first();

        $user->delete();

        return response()->json(null, 200);
    }


    public function getCountries(Request $request)
    {
        $top_country = GeoIP::getLocation($request->get('ip'))['country'];
        $top_country = Country::whereCountryNameEn($top_country)->first();
        $countries = Country::all()->toArray();

        if ($top_country) {
            $ids = [$top_country->id];
            $countries = Country::whereNotIn('id', $ids)->get()->toArray();
            array_unshift($countries, $top_country);
        }

        $user = User::whereEmail($request->get('email'))->first();
        $token = $user ? $user->token : null;
        $promo_code_first = $user ? $user->promo_code_first : null;
        $promo_code_second = $user ? $user->promo_code_second : null;

        return response()->json([
            'token' => $token,
            'promo_code_first' => $promo_code_first,
            'promo_code_second' => $promo_code_second,
            'countries' => $countries
        ], 200);
    }
}
