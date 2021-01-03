<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 10.12.18
 * Time: 10:39
 */

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Api\V1\LoginHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Models\Promocode;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;
use GeoIP;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api\V1
 */
class UserController extends Controller
{
    /**
     * @var \App\Models\User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    private $user = null;

    /**
     * UserController constructor.
     *
     * @param \App\Http\Requests\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
        //$this->user = User::whereToken('test1')->first();
    }

    /**
     * @param \App\Http\Requests\Api\V1\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $code = 200;
        $data = $request->validated();
        $helper = new LoginHelper($data['email']);

        if (! empty($data['username'])) {
            $helper->setUsername($data['username']);
        }
        if (! empty($data['country_id'])) {
            $helper->setCountryId($data['country_id']);
            //$helper->setCountryId(219);
        }

        $response_data = $helper->login();

        if (is_array($response_data)) {
            $code = 201;
        }

		//print_r($response_data); exit;

        return response()->json($response_data, $code, [], JSON_FORCE_OBJECT);
    }

    /**
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countriesList(Request $request)
    {
        $top_country = GeoIP::getLocation($request->ip())['country'];
        $top_country = Country::whereCountryNameEn($top_country)
            ->first();
        $countries = Country::all()
            ->toArray();

        if ($top_country) {
            $ids = [$top_country->id];
            $countries = Country::whereNotIn('id', $ids)
                ->get()
                ->toArray();
            array_unshift($countries, $top_country);
        }

		

        $user = User::whereEmail($request->get('email'))->first();
        //$user = $this->user;
        $token = $user ? $user->token : null;
		
		
		
        $promo_code_first = $user ? $user->promo_code_first : null;
        $promo_code_second = $user ? $user->promo_code_second : null;

        return response()->json([
            'token'             => $token,
            'first_promo_code'  => $promo_code_first,
            'second_promo_code' => $promo_code_second,
            'countries'         => $countries,
        ], 200);
    }

    /**
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateCode(Request $request)
    {
        $code = $request->get('promo_code');

        if ($this->user->activation_code || $this->user->promo_code_first == $code || $this->user->promo_code_second == $code) {

            return response()->json(null, 405);
        }

        $settings = Settings::first();

        $rate = $settings->rate;

        $standard_award = $settings->award_standard_promo_code;
        $partner_award = $settings->award_partner_promo_code;

        if ($first = Promocode::whereCode($code)
            ->first()) {
            $this->user->activation_code = $code;
            $this->user->balance = $this->user->balance + $rate * $partner_award;
            $this->user->save();

            return response()->json(null, 200);
        };

        $referral = User::wherePromoCodeFirst($code)
            ->first();
        $referral_second = User::wherePromoCodeSecond($code)
            ->first();

        if ($referral || $referral_second) {

            $this->user->activation_code = $code;
            $this->user->referrer_id = ($referral) ? $referral->id : $referral_second->id;
            $this->user->balance = $this->user->balance + $rate * $standard_award;
            $this->user->save();

            //$this->progress(($referral) ? $referral : $referral_second, 'referral');

            //$referral->referralPaid()->attach($this->user->id);

            return response()->json(null, 200);
        } else {

            return response()->json(null, 200);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/user/fcm",
     *     summary="Update the user's fcm token",
     *     tags={"user"},
     *     operationId="Update the user's fcm token",
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
     *         name="fcm_token",
     *         in="query",
     *         description="fcm_token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     *
     * ),
     */
    public function updateFcmToken(Request $request)
    {
        $this->user->update([
            'fcm_token' => $request->get('fcm_token')
        ]);

        return response()->json(null, 200);
    }
}
