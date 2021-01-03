<?php

namespace App\Http\Controllers;

use App;
use App\Contracts\Services\CurrencyServiceInterface;
use App\Helpers\DateHelper;
use App\Models\Award;
use App\Models\Country;
use App\Models\Role;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTask;
use App\Services\CurrencyService;
use Carbon\Carbon;
use Charts;
use ConsoleTVs\Charts\Builder\Chart;
use ConsoleTVs\Charts\Builder\Multi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use View;

class ChartController extends Controller
{
    /** @var CurrencyService */
    private $currencyService;
    /** @var string */
    private $currency;

    public function __construct(CurrencyServiceInterface $currencyService)
    {
        $this->currencyService = $currencyService;
        $this->currency = $currencyService->getCurrency();
    }

    /**
     * @param Request|null $request
     *
     * @return array|\Illuminate\Contracts\View\View
     */
    public function drawUsersTasksChart(Request $request)
    {
        /** @var Task $last_updated_task */
        $last_updated_task = UserTask::query()->latest()->first();

        if (is_null($request)) {
            $date_to = $last_updated_task->updated_at->endOfDay();
        } elseif (empty($request->date_to)) {
            $date_to = Carbon::today()->endOfDay();
        } else {
            $date_to = Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay();
        }

        if (is_null($request)) {
            $date_from = $last_updated_task->updated_at->startOfDay()->subDays(6);
        } elseif (empty($request->date_from)) {
            $date_from = Carbon::today()->subDays(6)->startOfDay();
        } else {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->get('date_from'))->startOfDay();
        }

        $dates = DateHelper::getDatesBetween($date_from, $date_to);

        $app_installs = [];
        $app_runs = [];
        for ($i = 0; $i < count($dates); $i++) {
            $app_runs[] = 0;
        }
        $app_runs_collections = [];
        $app_fails = [];

        /** @var Carbon $date */
        foreach ($dates as $index => $date) {
            $date_string = $date->toDateString();
            $dates[$index] = $date->format('d-m-Y');

            $app_installs[] = UserTask::query()->whereDate('created_at', '=', $date_string)->count();

            $app_runs_collections[$index] = UserTask::query()
                ->whereDate('last_open', '=', $date_string)->get(['times', 'failed_times']);

            $app_fails[] = UserTask::query()->whereDate('created_at', '=', $date_string)
                ->where('failed_times', '>', 0)->count();
        }

        /*
         * For correct counting application runnings at days by users.
         */
        if ($days_count = count($app_runs_collections)) {
            /** @var Collection $collection */
            foreach ($app_runs_collections as $index => $collection) {
                if ($collection->count()) {
                    foreach ($collection as $task) {
                        if ($task->times > 1) {
                            for ($i = $task->times; $i > 1; $i--) {
                                $key = $index - $i + 2;
                                if (array_key_exists($key, $app_runs)) {
                                    $app_runs[$key] += 1;
                                }
                            }
                        } else {
                            $app_runs[$index] += 1;
                        }
                        if ($task->failed_times > 1) {
                            for ($i = $task->failed_times; $i > 1; $i--) {
                                $key = $index - $i + 2;
                                if (array_key_exists($key, $app_fails)) {
                                    $app_fails[$key] += 1;
                                }
                            }
                        }
                    }
                }
            }
        }

        /** @var Multi $chart */
        $chart = Charts::multi('line', 'highcharts');
        $chart->dataset(trans('labels.installs'), $app_installs);
       // $chart->dataset(trans('labels.runs'), $app_runs);
        //$chart->dataset(trans('labels.failed'), $app_fails);
        $chart->title(trans('labels.tasks_chart'));
        $chart->elementLabel(' ');
        $chart->colors(['#60d7e9', '#D69EBA', '#FFBBA6']);
        $chart->labels($dates);
        $chart->credits(false);
        

        $data = [
            'chart' => $chart->render(),
            'total_app_installs' => array_sum($app_installs),
            'total_app_runs' => array_sum($app_runs),
            'total_app_fails' => array_sum($app_fails),
        ];

        // When requests from ajax - return generated view
        if ($request && $request->wantsJson()) {
            return View::make('admin._tasksChart', [
                'usersTasksChart' => $data,
            ]);
        }

        return $data;
    }

    /**
     * @param Request|null $request
     *
     * @return array|\Illuminate\Contracts\View\View
     */
    public function drawRegisterChart(Request $request)
    {
        if (is_null($request)) {
            $date_to = Carbon::today()->endOfDay();
        } elseif (empty($request->date_to)) {
            $date_to = Carbon::today()->endOfDay();
        } else {
            $date_to = Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay();
        }

        if (is_null($request)) {
            $date_from = Carbon::today()->subDays(6)->startOfDay();
        } elseif (empty($request->date_from)) {
            $date_from = $date_to->copy()->subDays(6)->startOfDay();
        } else {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->get('date_from'))->startOfDay();
        }

        $dates = DateHelper::getDatesBetween($date_from, $date_to);

        $registers_user = [];
        $registers_manager = [];

        /** @var Role $role_user */
        $role_user = Role::query()->find(Role::USER_ROLE_ID);
        /** @var Role $role_manager */
        $role_manager = Role::query()->find(Role::MANAGER_ROLE_ID);
        /** @var Carbon $date */
        foreach ($dates as $index => $date) {
            $date_string = $date->toDateString();
            $dates[$index] = $date->format('d-m-Y');

            $registers_user[] = $role_user->users()->whereDate('created_at', '=', $date_string)->count();
            $registers_manager[] = $role_manager->users()->whereDate('created_at', '=', $date_string)->count();
        }

        /** @var Multi $chart */
        
        $chart = Charts::multi('line', 'highcharts');
        $chart->dataset(trans('labels.registers_user'), $registers_user);
        $chart->dataset(trans('labels.registers_manager'), $registers_manager);
        $chart->title(trans('labels.register_chart'));
        $chart->elementLabel(' ');
        $chart->colors(['#5bbed4', '#da61ff']);
        $chart->labels($dates);
        $chart->credits(false);
        

        $data = [
            'chart' => $chart->render(),
            'total_registers_user' => array_sum($registers_user),
            'total_registers_manager' => array_sum($registers_manager),
        ];

        // When requests from ajax - return generated view
        if ($request && $request->wantsJson()) {
            return View::make('admin._registerChart', [
                'registerChart' => $data,
            ]);
        }

        return $data;
    }

    /**
     * @param Request|null $request
     *
     * @return array|\Illuminate\Contracts\View\View
     */
    public function drawAwardsChart(Request $request)
    {
        if (is_null($request)) {
            $date_to = Carbon::today()->endOfDay();
        } elseif (empty($request->date_to)) {
            $date_to = Carbon::today()->endOfDay();
        } else {
            $date_to = Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay();
        }

        if (is_null($request)) {
            $date_from = Carbon::today()->subDays(3)->startOfDay();
        } elseif (empty($request->date_from)) {
            $date_from = $date_to->copy()->subDays(3)->startOfDay();
        } else {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->get('date_from'))->startOfDay();
        }

        $dates = DateHelper::getDatesBetween($date_from, $date_to);

        $awards = [];
        /** @var Carbon $date */
        foreach ($dates as $index => $date) {
            $date_string = $date->toDateString();
            $dates[$index] = $date->format('d-m-Y');

            $amount = Award::query()->whereDate('created_at', '=', $date_string)->sum('amount');

            $awards[] = $this->currencyService->convertFromRub($amount);
        }

        /** @var Chart $chart */
        $chart = Charts::create('area', 'highcharts');
        $chart->title(trans('labels.awards_chart'));
        $chart->elementLabel($this->currency);
        $chart->colors(['#4CAF50']);
        $chart->labels($dates);
        $chart->values($awards);
        $chart->credits(false);

        $currency = $this->currency;

        $data = [
            'chart' => $chart->render(),
            'total_awards' => number_format(array_sum($awards), 2, '.', ' ') . " ${currency}",
        ];

        // When requests from ajax - return rendered view
        if ($request && $request->wantsJson()) {
            return View::make('admin._awardsChart', [
                'awardsChart' => $data,
            ]);
        }

        return $data;
    }

    public function drawTotalEarnedMoney()
    {
        $users_earned = $this->currencyService
            ->convertFromRub(User::searchByRole('user')->sum('balance'));
        $managers_earned = $this->currencyService
            ->convertFromRub(User::searchByRole('manager')->sum('balance'));

        $currency = $this->currency;

        /** @var Chart $chart */
        $chart = Charts::create('donut', 'highcharts');
        $chart->title(trans('labels.earned_chart') . " (${currency})");
        $chart->colors(['#da61ff', '#60d7e9']);
        $chart->labels([trans('labels.users'), trans('labels.managers')]);
        $chart->values([$users_earned, $managers_earned]);
        $chart->credits(false);

        return $chart->render();
    }

    public function drawTransactionsChart(Request $request)
    {
        if (is_null($request)) {
            $date_to = Carbon::today()->endOfDay();
        } elseif (empty($request->date_to)) {
            $date_to = Carbon::today()->endOfDay();
        } else {
            $date_to = Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay();
        }

        if (is_null($request)) {
            $date_from = Carbon::today()->subDays(6)->startOfDay();
        } elseif (empty($request->date_from)) {
            $date_from = $date_to->copy()->subDays(6)->startOfDay();
        } else {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->get('date_from'))->startOfDay();
        }

        $success = Transaction::whereState(Transaction::STATUS_OK)
            ->whereDate('created_at', '>=', $date_from->toDateString())
            ->whereDate('created_at', '<=', $date_to->toDateString())
            ->count();
        $rejected = Transaction::whereState(Transaction::STATUS_REJECTED)
            ->whereDate('created_at', '>=', $date_from->toDateString())
            ->whereDate('created_at', '<=', $date_to->toDateString())
            ->count();

        /** @var Chart $chart */
        $chart = Charts::create('pie', 'highcharts');
        $chart->title(trans('labels.buttons.transactions'));
        $chart->labels([trans('labels.transactions.plural.successful'), trans('labels.transactions.plural.rejected')]);
        $chart->values([$success, $rejected]);
        $chart->credits(false);

        $data = [
            'chart' => $chart->render(),
            'total' => $success + $rejected,
            'total_success' => $success,
            'total_rejected' => $rejected,
        ];

        // When requests from ajax - return generated view
        if ($request && $request->wantsJson()) {
            return View::make('admin._transactionsChart', [
                'transactionsChart' => $data,
            ]);
        }

        return $data;
    }

    public function drawTransactionsAmountChart(Request $request)
    {
        if (is_null($request)) {
            $date_to = Carbon::today()->endOfDay();
        } elseif (empty($request->date_to)) {
            $date_to = Carbon::today()->endOfDay();
        } else {
            $date_to = Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay();
        }

        if (is_null($request)) {
            $date_from = Carbon::today()->subDays(6)->startOfDay();
        } elseif (empty($request->date_from)) {
            $date_from = $date_to->copy()->subDays(6)->startOfDay();
        } else {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->get('date_from'))->startOfDay();
        }

        $success = $this->currencyService->convertFromRub(
            Transaction::whereState(Transaction::STATUS_OK)
                ->whereDate('created_at', '>=', $date_from->toDateString())
                ->whereDate('created_at', '<=', $date_to->toDateString())
                ->sum('amount')
        );

        $rejected = $this->currencyService->convertFromRub(
            Transaction::whereState(Transaction::STATUS_REJECTED)
                ->whereDate('created_at', '>=', $date_from->toDateString())
                ->whereDate('created_at', '<=', $date_to->toDateString())
                ->sum('amount')
        );

        $currency = $this->currency;

        /** @var Chart $chart */
        $chart = Charts::create('pie', 'highcharts');
        $chart->title(trans('labels.transactions_amount') . " (${currency})");
        $chart->labels([trans('labels.transactions.plural.successful'), trans('labels.transactions.plural.rejected')]);
        $chart->values([$success, $rejected]);
        $chart->credits(false);

        $data = [
            'chart' => $chart->render(),
            'total' => number_format($success + $rejected, 2, '.', ' ') . " ${currency}",
            'total_success' => number_format($success, 2, '.', ' ') . " ${currency}",
            'total_rejected' => number_format($rejected, 2, '.', ' ') . " ${currency}",
        ];

        // When requests from ajax - return generated view
        if ($request && $request->wantsJson()) {
            return View::make('admin._transactionsChart', [
                'transactionsChart' => $data,
            ]);
        }

        return $data;
    }

    public function drawLocationsChart()
    {
        $countries = Country::query()->whereHas('users', function (Builder $query) {
            $query->groupBy('country_name_en');
        })->get();

        $labels = [];
        $values = [];

        $country_codes = \File::getRequire(resource_path('lang/en/country_codes.php'));

        /** @var Country $country */
        foreach ($countries as $country) {
            $labels[] = array_search($country->country_name_en, $country_codes);
            $values[] = $country->users()->count();
        }

        /** @var Chart $chart */
        $chart = Charts::create('geo', 'highcharts');
        $chart->title(trans('labels.locations'));
        $chart->elementLabel(' ');
        $chart->colors(['#5dc7bf', '#b033bc']);
        $chart->labels($labels);
        $chart->values($values);

        return $chart->render();
    }

    public function drawLocationsPieChart()
    {
        $country_count = [];
        $countries = Country::query()->whereHas('users', function (Builder $query) {
            $query->groupBy('country_name_en');
        })->get()->sortByDesc(function (Country $country) use (&$country_count) {
            $count = $country->users()->count();
            $country_count[$country->country_name_en] = $count;

            return $count;
        });

        $countries_other = $countries->splice(8);

        $labels = [];
        $values = [];

        /** @var Country $country */
        foreach ($countries as $country) {
            if (App::isLocale('ru')) {
                $labels[] = $country->country_name_ru;
            } else {
                $labels[] = $country->country_name_en;
            }

            $values[] = $country_count[$country->country_name_en];
        }

        $other_users = 0;

        foreach ($countries_other as $country) {
            $other_users += $country_count[$country->country_name_en];
        }

        $labels[] = trans('labels.other');
        $values[] = $other_users;

        /** @var Chart $chart */
        $chart = Charts::create('pie', 'highcharts');
        $chart->title(trans('labels.locations'));
        $chart->elementLabel(' ');
        $chart->labels($labels);
        $chart->values($values);

        return $chart->render();
    }
}
