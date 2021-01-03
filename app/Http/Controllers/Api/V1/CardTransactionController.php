<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SendEventNotification;
use App\Models\CardTransaction;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBonusCard;
use App\Models\UserCardTransaction;
use Illuminate\Http\Request;
use Twilio\Rest\Preview\Understand\Assistant\ReadQueryOptions;

class CardTransactionController extends Controller
{
    protected $user;

    private static $hidden_card_tracsaction_attributes = [
        'top',
        'created_at',
        'updated_at',
    ];

    private static $hidden_pivot_c_t_attributes = [
        'user_id',
        'card_transaction_id',
        'used',
        'created_at',
        'updated_at',
    ];

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
    }

    /**
     * @SWG\Get(
     *     path="/api/cards/transactions/get",
     *     summary="Get cards transactions",
     *     tags={"transactions"},
     *     operationId="Get cards transactions",
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
     *         @SWG\Schema(ref="#/definitions/GetCardsTransaction")
     *  ),
     * ),
     */
    public function getCardsTransaction()
    {
        $rate = Settings::first()->rate;

        $top = CardTransaction::whereTop(1)->whereActive(1)->get()->map(
            function ($card) {
                $card->makeHidden(self::$hidden_card_tracsaction_attributes);

                return $card;
            }
        );

        $cards = CardTransaction::whereTop(0)->whereActive(1)->get()->map(
            function ($card) {
                $card->makeHidden(self::$hidden_card_tracsaction_attributes);

                return $card;
            }
        );

        return response()->json([
            'rate' => $rate,
            'top' => $top,
            'cards' => $cards,
        ], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/cards/transactions/user/get",
     *     summary="Get users cards transactions",
     *     tags={"transactions"},
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
     *             @SWG\Items(ref="#/definitions/UserCardTransaction")
     *         )
     *  ),
     * ),
     */
    public function getUsersCardTransaction()
    {
        $cards = $this->user->cardTransactions()->whereUsed(0)
            ->get()
            ->map(function ($card) {
                $card->makeHidden(self::$hidden_card_tracsaction_attributes);
                $card->pivot->makeHidden(self::$hidden_pivot_c_t_attributes);

                $card->pivot->amount = (float)number_format($card->pivot->amount, 2, '.', '');

                return $card;
            });

        return response()->json($cards, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/cards/transactions/user/buy",
     *     summary="Buy card transaction",
     *     tags={"transactions"},
     *     operationId="Buy card transaction",
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
     *         description="id of card transaction",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount",
     *         required=true,
     *         type="number",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     *     @SWG\Response(
     *         response=413,
     *         description="This card transaction isn't found",
     *     ),
     *     @SWG\Response(
     *         response=414,
     *         description="Money on balance aren't enough",
     *     ),
     * ),
     */
    public function buyCardTransaction(Request $request)
    {
        $rate = Settings::first()->rate;

        if ($this->user->balance >= ($request->get('amount') * $rate)) {

            $card = CardTransaction::find($request->get('id'));
            if ($card) {
                /*$this->user->cardTransactions()->attach([
                    'card_transaction_id' => $card->id,
                    'amount' => $request->get('amount'),
                ]);*/
                UserCardTransaction::create([
                    'user_id' => $this->user->id,
                    'card_transaction_id' => $card->id,
                    'amount' => $request->get('amount'),
                ]);
                $this->user->balance -= $request->get('amount') * $rate;
                $this->user->save();

                return response()->json(null, 200);
            } else {

                return response()->json(null, 413);
            }

        } else {

            return response()->json(null, 414);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/cards/transactions/user/use",
     *     summary="Use card transaction",
     *     tags={"transactions"},
     *     operationId="Use card transaction",
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
     *         description="ud of pivot card transaction",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="data",
     *         in="query",
     *         description="data",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     *     @SWG\Response(
     *         response=415,
     *         description="This card transaction isn't found",
     *     ),
     *     @SWG\Response(
     *         response=417,
     *         description="Validation error",
     *     ),
     * ),
     */
    public function useCardTransaction(Request $request)
    {
        $card = $this->user->cardTransactions()->wherePivot('ud', '=', $request->get('id'))->first();

        if ($card) {

            $data = $request->get('data');
            $correct = 1;

            switch ($card->title) {
                case 'WebMoney':
                    if ($data[0] != 'R' || strlen($data) != 13) {
                        $correct = 0;
                    } else {
                        for($i = 1; $i < 13; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'YandexMoney':
                    if (strlen($data) != 15) {
                        $correct = 0;
                    } else {
                        for ($i = 0; $i < 15; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'Qiwi':
                    if ($data[0] != '+' || strlen($data) != 12) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < 12; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'МТС':
                    if ($data[0] != '+' || strlen($data) != 12) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < 12; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'Tele2':
                    if ($data[0] != '+' || strlen($data) != 12) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < 12; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'Мегафон':
                    if ($data[0] != '+' || strlen($data) != 12) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < 12; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'Beeline':
                    if ($data[0] != '+' || strlen($data) != 12) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < 12; $i++) {
                            if (!is_numeric($data[$i])) {
                                $correct = 0;
                                break;
                            }
                        }
                    }
                    break;
                case 'PayPal':
                    if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
                        break;
                    } else {
                        $correct = 0;
                    }
                    break;
                case 'World of Tanks':
                    if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
                        break;
                    } else {
                        $correct = 0;
                    }
                    break;
            }

            if ($correct == 0) {

                return response()->json(null, 417);

            }

            $pivot = UserCardTransaction::whereUd($request->get('id'))->first();
            $pivot->used = 1;
            $pivot->save();

            $this->user->update([
                'during' => $this->user->during + $card->pivot->amount,
            ]);

            $this->user->transactions()->create([
                'phone' => $data,
                'amount' => $card->pivot->amount,
                'amount_clean' => $card->pivot->amount,
                'method' => $card->title,
                'response' => null,
                'locked' => false,
                'manual' => true,
                'restored' => false,
                'state' => Transaction::STATUS_PENDING
            ]);

            return response()->json(null, 200);

        } else {

            return response()->json(null, 415);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/cards/transactions/bonus",
     *     summary="Get transaction card progress bar for user",
     *     tags={"transactions"},
     *     operationId="Get transaction card progress bar for user",
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
     *         @SWG\Schema(ref="#/definitions/CardTransactionProgressBar")
     *     ),
     * ),
     */
    public function getProgressBar()
    {
        $rate = Settings::first()->rate;
        $goal = 1000 * $rate;
        $progress = (integer) (($this->user->cardTransactions()->sum('user_card_transactions.amount')) / (1000 / 100));

        if ($progress >= 100) {
            $progress = 100;
            if (!$this->user->event) {
                $this->user->event = 1;
                $this->user->save();
                $this->dispatch(new SendEventNotification($this->user));
            }
        }

        return response()->json([
            'goal' => $goal,
            'progress' => $progress
        ], 200);
    }
}
