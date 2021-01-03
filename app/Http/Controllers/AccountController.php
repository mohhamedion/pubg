<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\User;
use App\Models\UserBalanceReplenishment;
use Flash;
use Illuminate\Http\JsonResponse;
use Session;

class AccountController extends BaseController
{
    public function index(): View
    {
        $title = trans('labels.account.account');
        $user = $this->auth_user;

        return view('pages.account', compact('title', 'user'));
    }

    public function update(UserRequest $request): RedirectResponse
    {
        $this->auth_user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        //Flash::success(trans('messages.user_successfully_edited'));

        return redirect()->back();
    }

    public function updatePassword(PasswordChangeRequest $request): RedirectResponse
    {
        $this->auth_user->update([
            'password' => bcrypt($request->input('new_password')),
        ]);

        //Flash::success(trans('messages.password_change_success'));

        return redirect()->back();
    }

    /**
     * Display form of manager balance replenishment.
     *
     * @return RedirectResponse|View
     */
    public function balance()
    {
        // Allow access to this page only for managers
        if (!$this->is_manager) {
            Flash::error(trans('messages.access_denied'));

            return redirect('/');
        }

        $title = trans('labels.account.balance_replenishment');
        $min_replenishment = Settings::getInstance()->getAttributeValue('balance_replenishment_min');
        $user = $this->auth_user;

        $replenishment_history = $user->balanceReplenishments()
            ->orderByDesc('created_at')
            ->get(['amount', 'ik_inv_id', 'unitpayId', 'created_at']);

        // Reformat date and process amount to correct currency
        // Reformat date and process amount to correct currency
        $replenishment_history->map(function (UserBalanceReplenishment $replenishment) {
            $replenishment->amount = (float)number_format($replenishment->amount, 2, '.', '');
            //$this->currency->convertFromRub($replenishment->amount);

            return $replenishment;
        });

        return view('pages.accountBalance', compact('user', 'title', 'min_replenishment', 'replenishment_history'));
    }

    /**
     * Get interkassa interact after manager balance replenish.
     * Validating request and update manager balance.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function replenishmentInteract(Request $request): JsonResponse
    {
        $method = $request->get('method');
        $params = $request->get('params');
//        $signature = $this->getSignature($method, $params, env('UNITPAY_SECRET_KEY'));
        $signature = $this->getSignature($method, $params, '7f77a11359249d9100fcb6111694d863');
        if ($signature !== $params['signature']) {
            return new JsonResponse([
                'error' => [
                    'message' => 'Signature mismatch.',
                ],
            ]);
        }

        if (intval($params['test']) === 0 && $method === 'pay') {
            /** @var User $user */
            $user = User::whereEmail($params['account'])->first();
            if (!is_null($user)) {
                $amount = (float)$params['orderSum'];
                // Converting currencies
                if ($params['orderCurrency'] === 'UAH') {
                    Session::put('country', 'Ukraine');
                    $amount = $this->currency->convertToRub($amount);
                    Session::put('country', 'Russia');
                }

                if (UserBalanceReplenishment::where('unitpayId', '=', $params['unitpayId'])->exists()) {
                    return new JsonResponse([
                        'error' => [
                            'message' => 'Payment ID duplicating.',
                        ],
                    ]);
                }

                // After all validations - write to database
                $user->balanceReplenishments()->create([
                    'unitpayId' => intval($params['unitpayId']),
                    'amount' => $amount,
                ]);
                /*
                 * Calculate cashback
                 * If $amount < 10 000 => return 0
                 */
                $cashback = Settings::getInstance()->calcCashback($amount);

                $user->update([
                    'balance' => $user->balance + $amount + $cashback,
                ]);
            }
        }

        return new JsonResponse([
            'result' => [
                'message' => 'Success',
            ],
        ]);
    }

    /**
     * Callback on UnitPay payment.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReplenishment(Request $request): RedirectResponse
    {
        switch ($request->get('s')) {
            case 'success':
                Flash::success('<div style="font-size: 12pt">'
                    . trans('messages.balance_replenish_success', ['id' => $request->get('paymentId')]) . '</div>');
                break;
            case 'failed':
                Flash::error('<div style="font-size: 12pt">'
                    . trans('messages.order_error', ['id' => $request->get('paymentId')]) . '</div>');
                break;
        }

        return redirect()->route('account::balance');
    }

    public function balanceReplenishment(Request $request): RedirectResponse
    {
        //$url = 'https://unitpay.ru/pay/' . env('UNITPAY_PUBLIC_KEY');
        $url = 'https://unitpay.ru/pay/' . '136081-4d4b0';
        $sum = floatval($request->input('amount'));
        $account = $this->auth_user->email;
        $desc = trans('messages.payment_replenish_description');
        $currency = app(CurrencyServiceInterface::class)->getCurrencyCode();
//        $secretKey = env('UNITPAY_SECRET_KEY');
        $secretKey = '7f77a11359249d9100fcb6111694d863';
        $signature = $this->getFormSignature($account, $currency, $desc, $sum, $secretKey);
        $query = '?sum=' . $sum .
            '&account=' . $account .
            '&currency=' . $currency .
            '&desc=' . $desc .
            '&signature=' . $signature;

        $redirectUrl = $url . $query;

        return redirect()->to($redirectUrl);
    }

    private function getSignature(string $method, array $params, $secretKey): string
    {
        ksort($params);
        unset($params['sign']);
        unset($params['signature']);
        array_push($params, $secretKey);
        array_unshift($params, $method);
        return hash('sha256', join('{up}', $params));
    }

    private function getFormSignature($account, $currency, $desc, $sum, $secretKey): string
    {
        $hashStr = $account . '{up}' . $currency . '{up}' . $desc . '{up}' . $sum . '{up}' . $secretKey;

        return hash('sha256', $hashStr);
    }
}
