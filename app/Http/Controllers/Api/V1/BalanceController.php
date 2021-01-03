<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CardTransaction;
use App\Models\CardTransactionNominal;
use App\Models\LevelLimit;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCardTransaction;
use App\Traits\UserLevelTrait;
use Illuminate\Http\Request;

/**
 * Class BalanceController
 *
 * @package App\Http\Controllers\Api\V1
 */
class BalanceController extends Controller
{
    use UserLevelTrait;

    /**
     *
     * @var \App\Models\User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    private $user = null;

    /**
     * ProfileController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))
            ->first();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance()
    {
        return response()->json($this->user->balance, 200, [], JSON_FORCE_OBJECT);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json([
            'balance' => $this->user->balance,
            'paid'    => $this->user->paid,
        ], 200, [], JSON_FORCE_OBJECT);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function referral()
    {
        $limit = LevelLimit::whereLevel($this->user->level->referral[2])
            ->first();

        return response()->json([
            'referrals' => [
                'current' => $current = $this->user->referrals()
                    ->count(),
                'max'     => $max = $limit->referral,
                'percent' => (int)round(100 * $current / $max),
                'level'   => $this->user->level->referral[2],
            ],
            'balance'   => $this->user->referral_balance,
            'award'     => $this->getBonus($this->user, 'referral'),
            'paid'      => $this->user->referral_paid,
        ], 200, [], JSON_FORCE_OBJECT);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function cards()
    {
        $methods = CardTransaction::query()
            ->orderBy('top', 'DESC')
            ->where('active', '=', 1)
            ->get(['id', 'title'])
            ->makeHidden('image_url')
            ->toArray();
        $nominals = array_map(function ($item) {
            return $item['amount'];
        }, CardTransactionNominal::all(['amount'])
            ->sortBy('amount', SORT_ASC)
            ->toArray());

        return response()->json([
         
            'nominals' => $nominals,
            'uc_rate'     => Settings::first()->uc_rate,
            'popularity_rate'     => Settings::first()->popularity_rate,
        ], 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyCard(Request $request)
    {
        $rate = Settings::first()->rate;
        $amount = $request->get('amount'); //рубли
        $inner_amount = $rate * $amount; //рублики

        if ($this->user->balance >= $inner_amount) {
            $card = CardTransaction::find($request->get('method_id'));

            if (! empty($card)) {
                UserCardTransaction::create([
                    'user_id'             => $this->user->id,
                    'card_transaction_id' => $card->id,
                    'amount'              => $amount,
                ]);
                $this->user->balance -= $inner_amount;
                $this->user->save();

                return response()->json([], 200, [], JSON_FORCE_OBJECT);
            }
        }

        return response()->json([], 412, [], JSON_FORCE_OBJECT);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCards()
    {
        $cards = UserCardTransaction::query()
            ->where('used', '=', false)
            ->where('user_id','=',$this->user->id)
            ->get()
            ->makeHidden([
                'user_id',
                'used',
                'created_at',
                'updated_at',
            ])
            ->toArray();
        foreach ($cards as $index => $card) {
            $cards[$index]['method_name'] = (CardTransaction::find($card['card_transaction_id']))->title;
            $cards[$index]['method_id'] = (CardTransaction::find($card['card_transaction_id']))->id;
            unset($cards[$index]['card_transaction_id']);
        }

        return response()->json($cards, 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function useCard(Request $request)
    {
        $card = $this->user->cardTransactions()
            ->wherePivot('ud', '=', $request->get('ud'))
            ->first();

        if ($card) {

            $data = $request->get('data');
            $correct = 1;

            switch ($card->title) {
                case 'WebMoney':
                    if (strlen($data) != 13) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < 13; $i++) {
                            if (! is_numeric($data[$i])) {
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
                case 'МТС':
                case 'Tele2':
                case 'Мегафон':
                case 'Beeline':
                    $len  = strlen($data);
                    if ($data[0] != '+' || ($len < 9 && $len >= 20)) {
                        $correct = 0;
                    } else {
                        for ($i = 1; $i < $len; $i++) {
                            if (! is_numeric($data[$i])) {
                                $correct = 0;
                            }
                        }
                    }
                    break;
                case 'PayPal':
                case 'World of Tanks':
                    if (! filter_var($data, FILTER_VALIDATE_EMAIL)) {
                        $correct = 0;
                    }
                    break;
                default:
                    $correct = 1;
            }

            if ($correct == 0) {

                return response()->json([], 417, [], JSON_FORCE_OBJECT);
            }

            $pivot = UserCardTransaction::whereUd($request->get('ud'))
                ->first();
            $pivot->used = 1;
            $pivot->save();

            $this->user->update([
                'during' => $this->user->during + $card->pivot->amount,
            ]);

            $this->user->transactions()
                ->create([
                    'phone'        => $data,
                    'amount'       => $card->pivot->amount,
                    'amount_clean' => $card->pivot->amount,
                    'method'       => $card->title,
                    'response'     => null,
                    'locked'       => false,
                    'manual'       => true,
                    'restored'     => false,
                    'state'        => Transaction::STATUS_PENDING,
                ]);

            return response()->json([], 200, [], JSON_FORCE_OBJECT);
        } else {

            return response()->json([], 415, [], JSON_FORCE_OBJECT);
        }
    }
}
