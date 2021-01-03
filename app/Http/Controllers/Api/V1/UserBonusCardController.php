<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserBonusCardController extends Controller
{
    protected $user;

    private static $hidden_card_attributes = [
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
    }

    /**
     * @SWG\Get(
     *     path="/api/cards/get",
     *     summary="Get user's bonus cards",
     *     tags={"cards"},
     *     operationId="Get user's bonus cards",
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
     *             @SWG\Items(ref="#/definitions/BonusCard")
     *         )
     *  ),
     * ),
     */
    public function getBonusCards()
    {
        $bonusCards = $this->user->bonusCards()->get()
            ->map(function ($bonusCard) {
                if ($bonusCard->pivot->used == 0) {
                    $bonusCard->makeHidden('pivot');
                    $bonusCard->makeHidden(self::$hidden_card_attributes);

                    return $bonusCard;
                }

                return 0;
            })->filter(function ($bonusCard) {
                return !!$bonusCard;
            });

        return response()->json($bonusCards,200);
    }
}
