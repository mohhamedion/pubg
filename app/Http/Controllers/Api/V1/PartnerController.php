<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Partner;
use App\Models\User;
use App\Models\UserPartner;
use App\Traits\UserLevelTrait;
use Illuminate\Http\Request;
use DB;

class PartnerController extends Controller
{
    use UserLevelTrait;

    protected $user;

    private static $hidden_partner_attributes = [
        'top',
        'is_available',
        'created_at',
        'updated_at',
    ];

    private static $hidden_pivot_p_attributes = [
        'user_id',
        'partner_id',
        'pivot_times',
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/partners/update",
     *     summary="Update the partner",
     *     tags={"partners"},
     *     operationId="Update the partner",
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
     *         name="id",
     *         in="query",
     *         description="id of partner",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount",
     *         required=true,
     *         type="number",
     *
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     * ),
     */
    public function updatePartner(Request $request)
    {
        $partner = $this->user->partners()->find($request->get('id'));

        if (((integer) $request->get('amount')) <= 1) {
            return response()->json(null, 200);
        }

        if (!$partner) {
            $this->user->partners()->attach($request->get('id'));
            $partner = $this->user->partners()->find($request->get('id'));
        }

        $partner->pivot->times += 1;

        $bonus = $this->getBonus($this->user, 'partner');
        $this->progress($this->user, 'partner');
        $this->user->balance += $request->get('amount') + $bonus;
        $partner->pivot->earned = ((float) number_format($partner->pivot->earned, 2, '.', '')) + $request->get('amount') + $bonus;
        $this->user->logAward($request->get('amount') + $bonus , Award::AWARD_PARTNER, null);
        $this->user->save();
        $partner->pivot->save();

        return response()->json(null, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/partners/",
     *     summary="Get partners",
     *     tags={"tasks"},
     *     operationId="Get partners",
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
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Partner")
     *         )
     *  ),
     * ),
     */
	
	public function selectParther(Request $request)
	{
		$part = array(
			'user_id' => $this->user->id,
			"partner_id" => $request->partnerid
		);
		
		$ins = DB::table('user_partners')->insert($part);
		
		return response()->json('partner selected', 200);
	}
	
	public function getPartnersList()
	{
		$partners = Partner::where('lang', 'ru')->get();
		return response()->json($partners, 200);
	}
	 
    public function getPartners()
    {
        $ru_countries = [219, 220, 221, 222, 397];
        // if (in_array($this->user['country_id'], $ru_countries)) {
            // $partners = Partner::where('is_available', '=', '1')->where('lang', '=', 'ru')->get();
        // } else {
            // $partners = Partner::where('is_available', '=', '1')->where('lang', '=', 'en')->get();
        // }
		
		$partners = Partner::where('is_available', '=', '1')->where('lang', '=', 'en')->get();
		
		
		foreach($partners as $p)
		{
			if($p->title == "More tasks")
			{
				$p->id = 1;
			}
			if($p->title == "Best deals")
			{
				$p->id = 2;
			}
		}
		
		return response()->json($partners, 200);
		
		//$partners = Partner::query()->where('lang', '=', 'en');
		
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
		

        /*if (in_array($this->user->country_id, $ru_countries)) {
            $partners = $this->user->partners()->whereIsAvailable(1)->where('lang', 'ru')
                ->get()
                ->map(function ($partner) {
                    $partner->makeHidden(self::$hidden_partner_attributes);
                    $partner->award = $this->getBonus($this->user, 'partner');

                    $partner->pivot->earned = (float)number_format($partner->pivot->earned, 2, '.', '');
                    $partner->makeHidden('pivot');

                    return $partner;
                });
        } else {
            $partners = $this->user->partners()->whereIsAvailable(1)->where('lang', 'en')
                ->get()
                ->map(function ($partner) {
                    $partner->makeHidden(self::$hidden_partner_attributes);
                    $partner->award = $this->getBonus($this->user, 'partner');

                    $partner->pivot->earned = (float)number_format($partner->pivot->earned, 2, '.', '');
                    $partner->makeHidden('pivot');

                    return $partner;
                });        
		}*/



        return response()->json($user_partners, 200);
    }
}
