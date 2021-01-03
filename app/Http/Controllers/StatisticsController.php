<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\Award;
use App\Models\Promocode;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class StatisticsController extends BaseController
{
    /**
     * Display offers, video watching, vk group and roulette statistics.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $title = trans('labels.stats');

        $date_from = $request->get('date_from');
        $date_from = !empty($date_from) ? $date_from : null;
        $date_to = $request->get('date_to');
        $date_to = !empty($date_to) ? $date_to : null;
        $promocodes = Promocode::all();

        return view('stats.index', compact('title', 'date_from', 'date_to', 'promocodes'));
    }

    /**
     * Get statistics of all Awards.
     *
     * @param Request $request
     * @param CurrencyServiceInterface $currencyService
     * @return View
     */
    public function getData(Request $request, CurrencyServiceInterface $currencyService): View
    {
        $date_from = $request->get('date_from');
        $date_from = !empty($date_from) ? Carbon::createFromFormat('d-m-Y', $date_from)->toDateString() : null;
        $date_to = $request->get('date_to');
        $date_to = !empty($date_to) ? Carbon::createFromFormat('d-m-Y', $date_to)->toDateString() : null;
        $promo_code = $request->get('promocodes');

        $query = User::query()->searchByRole('user');

        if (!empty($promo_code)) {
            $query->where('activation_code', '=', $promo_code);
        }

        if (!is_null($date_from) && !is_null($date_to)) {
            $users_count = $query->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to)->count();
        } elseif (!is_null($date_from)) {
            $users_count = $query->whereDate('created_at', '>=', $date_from)->count();
        } elseif (!is_null($date_to)) {
            $users_count = $query->whereDate('created_at', '<=', $date_to)->count();
        } else {
            $users_count = $query->count();
        }

        $users_earned = $query->sum('balance');

        $task_award_query = Award::whereNotNull('application_id');

        if (!empty($promo_code)) {
            $task_award_query = Award::whereNotNull('application_id')->whereHas('user', function($query)  use ($promo_code){
                $query->where('activation_code', $promo_code);
            });
        }

        if (!is_null($date_from) && !is_null($date_to)) {
            $task_earned = $task_award_query->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to)
                ->sum('amount');
        } elseif (!is_null($date_from)) {
            $task_earned = $task_award_query->whereDate('created_at', '>=', $date_from)
                ->sum('amount');
        } elseif (!is_null($date_to)) {
            $task_earned = $task_award_query->whereDate('created_at', '<=', $date_to)
                ->sum('amount');
        } else {
            $task_earned = $task_award_query->sum('amount');
        }

        $video_earned = UserVideo::all()->sum('earned');

        if (!empty($promo_code)) {
            $video_earned = UserVideo::whereHas('user', function($query)  use ($promo_code){
                $query->where('activation_code', $promo_code);
            })->sum('earned');
        }

        $partner_earned = Award::awardsBetweenDate(Award::AWARD_PARTNER, $date_from, $date_to)
            ->sum('amount');

        if (!empty($promo_code)) {
            $partner_earned = Award::whereHas('user', function($query)  use ($promo_code){
                $query->where('activation_code', $promo_code);
            })
                ->awardsBetweenDate(Award::AWARD_PARTNER, $date_from, $date_to)
                ->sum('amount');
        }

        $referral_earned = Award::awardsBetweenDate(Award::AWARD_REFERRAL, $date_from, $date_to)
            ->sum('amount');

        if (!empty($promo_code)) {
            $referral_earned = Award::whereHas('user', function($query)  use ($promo_code){
                $query->where('activation_code', $promo_code);
            })
                ->awardsBetweenDate(Award::AWARD_REFERRAL, $date_from, $date_to)
                ->sum('amount');
        }

        $currency = $currencyService->getCurrency();

        $settings = Settings::first();

        $rate = $settings->rate;

        $stats = [
            'users_count' => $users_count,
            'users_earned' => ($users_earned / $rate) . " {$currency}",

            'task_earned' => ($task_earned / $rate) . " {$currency}",

            'video_earned' => ($video_earned / $rate) . " {$currency}",

            'partner_earned' => ($partner_earned / $rate) . " {$currency}",

            'referral_earned' => ($referral_earned / $rate) . " {$currency}",
        ];

        return \View::make('stats._table', compact('stats'));
    }

    public function getUsersStat(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $search = $request->get('search');
        $promo_code = $request->get('promocodes');
        $date_from = $request->get('date_from');
        $date_from = !empty($date_from) ? Carbon::createFromFormat('d-m-Y', $date_from)->toDateString() : null;
        $date_to = $request->get('date_to');
        $date_to = !empty($date_to) ? Carbon::createFromFormat('d-m-Y', $date_to)->toDateString() : null;
        // For editor display only users of application
        $role_id = $this->is_editor ? Role::USER_ROLE_ID : intval($request->get('role'));
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 3);
        $order = $order === 'asc' ? 4 : 3;
        $sort = $sort === 'balance_formatted' ? 'balance' : $sort;

        if ($role_id !== 0) {
            /** @var Role $role */
            $role = Role::query()->find($role_id);

            $query = $role->users();
        } else {
            $query = User::query()->searchByRole('user');
        }

        if (!empty($promo_code)) {
            $query->where('activation_code', '=', $promo_code);
        }

        if (!is_null($date_from) && !is_null($date_to)) {
            $query->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to);
        } elseif (!is_null($date_from)) {
            $query->whereDate('created_at', '>=', $date_from);
        } elseif (!is_null($date_to)) {
            $query->whereDate('created_at', '<=', $date_to);
        }

        if ($search) {
            $query = $query->searchByUserIdentifier($search);
            $total = $query->count();
            $rows = $query->skip($offset)->take($limit)->get()
                ->map(function ($user) {

                    $user->earned = $user->balance + $user->during + $user->paid;
                    $user->video_earned = $user->videos()->sum('earned');
                    $user->partner_earned = Award::whereUserId($user->id)
                        ->whereReferralSystem(Award::AWARD_PARTNER)
                        ->sum('amount');

                    return $user;
                })->sortBy($sort, $order);
        } else {
            $total = $query->count();
            $rows = $query->skip($offset)->take($limit)->get()
            ->map(function ($user) {

                $user->earned = $user->balance + $user->during + $user->paid;
                $user->video_earned = $user->videos()->sum('earned');
                $user->partner_earned = Award::whereUserId($user->id)
                    ->whereReferralSystem(Award::AWARD_PARTNER)
                    ->sum('amount');

                return $user;
            })->sortBy($sort, $order);
            $rows =  $rows->values()->all();
        }

        return response()->json(compact('total', 'rows'));
    }

    public function addPromocode(Request $request)
    {
        Promocode::create([
            'code' => $request->post('promocode'),
        ]);

        return redirect()->route('stats::index');
    }
}
