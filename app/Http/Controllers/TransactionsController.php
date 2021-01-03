<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Jobs\SendPaidTransactionNotification;
use App\Models\Settings;
use App\Models\Transaction;
use Carbon\Carbon;
use Flash;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $counts = [
            Transaction::STATUS_OK => [
                'count' => Transaction::getSuccessfulCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_OK)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_OK)['class'],
            ],
            Transaction::STATUS_SENT => [
                'count' => Transaction::getSentCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_SENT)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_SENT)['class'],
            ],
            Transaction::STATUS_REJECTED => [
                'count' => Transaction::getRejectedCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_REJECTED)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_REJECTED)['class'],
            ],
            Transaction::STATUS_PENDING => [
                'count' => Transaction::getPendingCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_PENDING)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_PENDING)['class'],
            ],
        ];

        $statuses = [
            Transaction::STATUS_OK => Transaction::getStatusForView(Transaction::STATUS_OK)['label'],
            Transaction::STATUS_SENT => Transaction::getStatusForView(Transaction::STATUS_SENT)['label'],
            Transaction::STATUS_REJECTED => Transaction::getStatusForView(Transaction::STATUS_REJECTED)['label'],
            Transaction::STATUS_PENDING => Transaction::getStatusForView(Transaction::STATUS_PENDING)['label']
        ];

        $methods = Transaction::query()->distinct()->pluck('method', 'method');
        $methods = $methods->map(function ($value) {
            return ucfirst($value);
        });

        return view('transactions.index', compact( 'counts', 'statuses', 'methods'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $sort = $request->get('sort');
        $order = $request->get('order', 'desc');
        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $date_from = !empty($request->get('date_from'))
            ? Carbon::createFromFormat('d-m-Y', $request->get('date_from'))
                ->startOfDay()->toDateTimeString()
            : null;

        $date_to = !empty($request->get('date_to'))
            ? Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay()->toDateTimeString()
            : Carbon::today()->endOfDay()->toDateTimeString();

        switch ($sort) {
            case 'amount_formatted':
                $sort = 'amount';
                break;
            case 'status_for_view':
                $sort = 'state';
                break;
        }

        if ($status !== 'all') {
            $query = Transaction::searchByStatus($status);
        } else {
            $query = Transaction::query();
        }

        if (is_null($date_from)) {
            $query->where('created_at', '<', $date_to);
        } else {
            $query->whereBetween('created_at', [$date_from, $date_to]);
        }

        if (!empty($search)) {
            $query->whereHas('user', function ($query) use ($search) {
                /** @var Builder $query */
                return $query->where('email', 'like', '%' . $search . '%')
                    ->orWhere('device_token', 'like', '%' . $search . '%')
                    ->orWhere('login', 'like', '%' . $search . '%')
                    ->orwhere('name', 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();
        $rows = $query->sort($sort, $order)->skip($offset)->take($limit)->get();

        return response()->json(compact('total', 'rows'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Transaction $transaction
     * @param CurrencyServiceInterface $currency
     * @return View
     */
    public function edit(Transaction $transaction, CurrencyServiceInterface $currency): View
    {
        $title = trans('labels.transactions.id', ['id' => $transaction->id]);

        $statuses = [
            Transaction::STATUS_OK => Transaction::getStatusForView(Transaction::STATUS_OK)['label'],
            Transaction::STATUS_SENT => Transaction::getStatusForView(Transaction::STATUS_SENT)['label'],
            Transaction::STATUS_REJECTED => Transaction::getStatusForView(Transaction::STATUS_REJECTED)['label'],
            Transaction::STATUS_PENDING => Transaction::getStatusForView(Transaction::STATUS_PENDING)['label']
        ];

        $user = $transaction->user;

        $referrals_count = $user->referrals()->count();
        $tasks_count = $user->tasks()->count();
        $awards_count = $user->awards()->count();
        $transactions_count = $user->transactions()->count();

        $earned_applications = $currency->convertFromRub(
            $user->awards()->whereNull('referral_system')->sum('amount')
        );

        $earned_total = $currency->convertFromRub($user->awards()->sum('amount'));

        $success_transaction_amount = $currency->convertFromRub(
            $user->transactions()->where('state', '=', Transaction::STATUS_OK)->sum('amount')
        );

        return view(
            'transactions.edit',
            compact(
                'title',
                'transaction',
                'statuses',
                'user',
                'referrals_count',
                'tasks_count',
                'awards_count',
                'transactions_count',
                'earned_applications',
                'earned_total',
                'success_transaction_amount'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param Transaction $transaction
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $state = $request->get('status', Transaction::STATUS_PENDING);

        $transaction->update([
            'state' => $state,
        ]);

        switch ($state) {
            case Transaction::STATUS_REJECTED:
                $transaction->restoreRequest();
                Flash::success(trans('messages.transaction_status_updated')
                    . ' ' . trans('messages.transaction_restored'));
                $settings = Settings::first();
                $rate = $settings->rate;
                $transaction->user->balance += $transaction->amount_clean * $rate;
                $transaction->user->save();

                break;
            case Transaction::STATUS_SENT:
                Flash::success(trans('messages.transaction_status_updated'));
                break;
            case Transaction::STATUS_OK:
                Flash::success(trans('messages.transaction_status_updated'));
                $this->dispatch(new SendPaidTransactionNotification($transaction->user, $transaction->method));
                $transaction->user->paid += $transaction->amount_clean;
                $transaction->user->save();
                break;
        }

        if (!is_null($token = $transaction->user->push_device_token)) {
            $this->dispatch(new SendTransactionStatePushNotification($token, $state));
        }

        return redirect()->back();
    }
}
