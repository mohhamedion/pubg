<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ApplicationApiServiceInterface;
use App\Contracts\Services\CampaignServiceInterface;
use App\Contracts\Services\CurrencyServiceInterface;
use App\Helpers\DateHelper;
use App\Jobs\AppDeferredStart;
use App\Jobs\SendDoneReviewNotification;
use App\Jobs\SendNewTaskNotification;
use App\Models\AppPrice;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\Settings;
use App\Models\Task;
use App\Models\TaskReview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Helpers\GooglePlayScrapper;
use Flash;
use Charts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View as ViewMake;
use Illuminate\Database\Eloquent\Builder;


class AppController extends BaseController
{
    public function __construct(CurrencyServiceInterface $currencyService)
    {
        parent::__construct($currencyService);
    }

    public function index(): View
    {
        $title = trans('labels.titles.campaigns');

        Task::all()->map(function ($task){
            if (!$task->price && $task->id != 1) {
                $task->delete();
            }
        });

        if ($this->is_admin) {
            $apps_count = Task::count();
            $manager_role = Role::where('id', '=', Role::MANAGER_ROLE_ID)->first();
            $managers_with_apps = $manager_role->users()->has('createdTasks')->pluck('email', 'id');
        } else {
            $apps_count = $this->auth_user->createdTasks()->count();
            $managers_with_apps = null;
        }

        if ($this->is_editor) {
            $applications = Task::whereAccepted(true)
                ->whereDone(false)
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('apps.readyToPublish', compact('title', 'applications'));
        }

        return view('apps.index', compact('title', 'apps_count', 'managers_with_apps'));
    }

    public function create( ApplicationApiServiceInterface $applicationApiService): View
    {
        $title = trans('labels.buttons.add_app');
        $application = Task::find(1);
        $application->id = null;

        $settings = Settings::getInstance([
            'exchange_rate_rub_uah',
            'application_downloads_min_limit',
        ]);

        $prices = AppPrice::getPrices();
        $countries = Country::query()->pluck('country_name_ru', 'id');
        $countries->prepend(trans('labels.all.countries'), 0);
        $status = true;
        $cities = [];

        $install_limit = Settings::getInstance()->getAttributeValue('application_downloads_min_limit');
        $user_type = $this->is_manager ? 'manager' : 'user';

        $can_be_changed = $application->canBeChanged();
        $countryGroups = $applicationApiService->generateCountryGroups($application);

        return view(
            'apps.edit',
            compact(
                'title',
                'application',
                'status',
                'settings',
                'prices',
                'countries',
                'cities',
                'install_limit',
                'user_type',
                'can_be_changed',
                'countryGroups'
            )
        );
    }

    public function getData(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $search = $request->get('search');
        $status = $request->get('status');
        $manager_id = (int)$request->get('manager_id', 0);

        $date_from = !empty($request->get('date_from'))
            ? Carbon::createFromFormat('d-m-Y', $request->get('date_from'))
                ->startOfDay()->toDateTimeString()
            : null;

        $date_to = !empty($request->get('date_to'))
            ? Carbon::createFromFormat('d-m-Y', $request->get('date_to'))->endOfDay()->toDateTimeString()
            : Carbon::today()->endOfDay()->toDateTimeString();

        switch ($sort) {
            case 'limit_state':
                $sort = 'limit';
                break;
            case 'formatted_created_at':
                $sort = 'created_at';
                break;
        }

        $user = $this->auth_user;
        switch ($user->role) {
            case Role::MANAGER_ROLE_ID:
                if (isset($search)) {
                    $query = $user->createdTasks()->search($search);
                } else {
                    $query = $user->createdTasks();
                }
                break;
            case Role::EDITOR_ROLE_ID:
                if (isset($search)) {
                    $query = Task::search($search);
                } else {
                    $query = Task::query();
                }
                break;
            default:
                if (isset($search)) {
                    $query = Task::search($search);
                } else {
                    $query = Task::query();
                }
        }

        if ($manager_id !== 0) {
            $query = $query->where('user_id', '=', $manager_id);
        }

        if (isset($status) && $status !== 'all') {
            switch ($status) {
                case 'not_paid':
                    $query->where('paid', '=', false)->where('done', false);
                    break;
                case 'not_moderated':
                    $query->where('paid', '=', true)->where('moderated', '=', false);
                    break;
                case 'declined':
                    $query->where('moderated', '=', true)->where('accepted', '=', false)->where('done', '=', false);
                    break;
                case 'ready':
                    $query->where('paid', '=', true)
                        ->where('moderated', '=', true)
                        ->where('accepted', '=', true)
                        ->where('active', '!=', true)
                        ->where('done', '!=', true);
                    break;
                case 'active':
                    $query->where('paid', '=', true)
                        ->where('moderated', '=', true)
                        ->where('accepted', '=', true)
                        ->where('active', '=', true);
                    break;
                case 'done':
                    $query->where('paid', '=', true)
                        ->where('moderated', '=', true)
                        ->where('accepted', '=', true)
                        ->where('done', '=', true);
                    break;
                case 'canceled':
                    $query->where('canceled', '=', true);
            }
        }

        if (is_null($date_from)) {
            $query->where('created_at', '<', $date_to);
        } else {
            $query->whereBetween('created_at', [$date_from, $date_to]);
        }

        $total = $query->count();

        $rows = $query
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort, $order)
            ->get()
            ->map( function ($row) {
                if ($row->id == 1) {
                    return 0;
                }
                $row->name = $row->title;
                $row->image = $row->image_url;
                return $row;
            })->filter(function ($row) {
                return !!$row;
            });

        return response()->json(compact('total', 'rows'));
    }

    /**
     * Show app for edit
     *
     * @param Task $application
     * @param ApplicationApiServiceInterface $applicationApiService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Task $application, ApplicationApiServiceInterface $applicationApiService): View
    {
        $title = trans('labels.edit_application');
        $settings = Settings::getInstance([
            'exchange_rate_rub_uah',
            'application_downloads_min_limit',
            'review_price',
            'review_comment_price',
            'description_price',
            'top_price',
            'run_after_price',
            //'click_price'
        ]);
        $prices = AppPrice::getPrices();
        $delay = '24h';
        switch ($application->time_delay) {
            case 48:
                $delay = '48h';
                break;
            case 72:
                $delay = '72h';
                break;
        }
        $countryGroups = $applicationApiService->generateCountryGroups($application);
		
		unset($countryGroups["europe"]);
		unset($countryGroups["america"]);
		unset($countryGroups["asia"]);
		unset($countryGroups["oceania"]);
		
        if ($application->country_group) {
            $lang = app()->getLocale();
            $countries = Country::whereIn('country_name_en', Country::GROUPS[$application->country_group])
                ->get()
                ->pluck("country_name_$lang", 'id');
            $countries->prepend(trans('labels.all.countries'), 0);
        } else {
            $countries = [];
        }
        /** @var Task $application */
        $cities = $application->country !== null ?
            $application->country->cities()->pluck('city_name_ru', 'id') : [];

        // Get users list cause admin can change owner of app
        if ($this->is_admin) {
            $users = User::query()->whereHas('roles', function ($query) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $query->whereIn('id', [Role::ADMIN_ROLE_ID, Role::MANAGER_ROLE_ID]);
            })->get()->pluck('email', 'id');
        } else {
            $users = null;
        }

        if (count($cities) > 0) {
            $cities->prepend(trans('labels.all.cities'), 0);
        }

        $install_limit = Settings::getInstance()->getAttributeValue('application_downloads_min_limit');

        $user_type = $this->is_manager ? 'manager' : 'user';

        $can_be_changed = $application->canBeChanged();

        $application->load('createdByUser')
            ->makeVisible(['description_active']);
        $application->image = $application->image_url;
        $application->name = $application->title;

        if ($application->other_type == 1) {
            $application->time_delay = 73;
        }

        return view(
            'apps.edit',
            compact(
                'title',
                'application',
                'settings',
                'prices',
                'delay',
                'countryGroups',
                'countries',
                'cities',
                'users',
                'install_limit',
                'user_type',
                'can_be_changed'
            )
        );
    }

    public function getAndroidInfo(Request $request): JsonResponse
    {
        $query = $request->get('query');
        $query_string = parse_url($query, PHP_URL_QUERY);
        if (!$query_string) {
            $package_name = $query;
        } else {
            parse_str($query_string, $query_array);
            if (isset($query_array['id'])) {
                $package_name = $query_array['id'];
            } else {
                $package_name = null;
            }
        }

        $scrapper = new GooglePlayScrapper();
        if($country = $request->get('country'))
            if($country = Country::whereCountryNameRu($country)->first()){
                $name = $country->country_name_en;
                $app = $scrapper->getApp($package_name, $name, $name);
            }
            else
                $app = $scrapper->getApp($package_name, $country, $country);
        else
            $app = $scrapper->getApp($package_name);

        return response()->json(compact('app'), 200);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $this->auth_user;

        $package_name = self::getApplicationPackageName($request->get('package_name'));

        $input = $request->all(
            'device_type',
            'package_name',
            'title',
            'image_url'
        );

        $input['package_name'] = $package_name;
        $input['price'] = AppPrice::getPrices()->getAttributeValue('android_daily_price_first_manager');

        //$input['limit'] = 0;
//        $input['limit'] = Settings::getInstance()->getAttributeValue('application_downloads_min_limit');
        // Set empty string manually cause MySQL doest not allow default empty string value
        $input['description'] = '';
        $input['days'] = Task::DEFAULT_DAYS_ATTR;
        $input['time_delay'] = Task::DEFAULT_TIME_DELAY_ATTR;

        $promotion = (int)$request->input('promotion_type');

        $application = new Task($input);

        $application->user()->associate($user);
        $application->createdByUser()->associate($user);

        if ($request->has('country') && $request->input('country') !== 0) {
            $country = Country::query()->find($request->input('country'));
            $application->country()->associate($country);
        } else {
            $application->country()->dissociate();
        }

        if (($promotion === 1 || $promotion === 2) && $request->has('city') && $request->input('city') !== 0) {
            $city = City::query()->find($request->input('city'));
            $application->city()->associate($city);
        } else {
            $application->city()->dissociate();
        }

        if ($promotion === 0 || $promotion === 1) {
            $application->keywords = null;
        }

        $application->setAttribute('min_tasks_limit_active', isset($request->min_tasks_limit_active));

        // If created by admin - do not create order
        if ($user->hasRole('admin')) {
            // And already paid, moderated and accepted
            $application->fill([
                'paid' => true,
                'moderated' => true,
                'accepted' => true,
            ]);
        }

        $application->save();

        //$this->dispatch(new ApplicationSaved($application->fresh()));

        Flash::success(trans('messages.app_added', [
            'app_name' => '<span class="label label-info">' . $application->name . '</span>'
        ]));

        return redirect()->route('apps::edit', ['application' => $application]);
    }

    private function getApplicationPackageName(string $package_name): string
    {
        $query_string = parse_url($package_name, PHP_URL_QUERY);

        if ($query_string) {
            parse_str($query_string, $query_array);
            if (isset($query_array['id'])) {
                $package_name = $query_array['id'];
            }
        }

        return $package_name;
    }

    public function getCampaignCustomParameters(Task $application, Request $request): View
    {
        $user_type = $this->is_manager ? 'manager' : 'user';
        $settings = Settings::getInstance([
            'exchange_rate_rub_uah',
            'application_downloads_min_limit',
            'review_price',
            'review_comment_price',
            'description_price',
        ]);
        $delay = '24h';
        switch ($application->time_delay) {
            case 24:
                $delay = '24h';
                break;
            case 48:
                $delay = '48h';
                break;
            case 72:
                $delay = '72h';
                break;
        }
        //$application->time_delay = $application->time;
        $group = $request->get('group', 'cis');
        $pricesAttributes = $group === 'cis' ? ['*'] : ['other_price', 'other_price_keywords'];
        $prices = AppPrice::getPrices($pricesAttributes);

        // For other countries allow edit of parameters only not admin
        $can_be_changed = $application->canBeChanged();
        $view = $group === 'cis' ? 'apps/_cisCountriesFormEdit' : 'apps/_otherCountriesFormEdit';
        $application->country_group = $request->get('group', 'cis');

        return view()->make($view, compact(
            'application',
            'settings',
            'prices',
            'delay',
//            'install_limit',
            'user_type',
            'can_be_changed'
        ));
    }

    public function getCustomParametersForCis(Task $application, Request $request): View
    {
        $user_type = $this->is_manager ? 'manager' : 'user';
        $settings = Settings::getInstance([
            'exchange_rate_rub_uah',
            'application_downloads_min_limit',
            'review_price',
            'review_comment_price',
            'description_price',
            'top_price'
        ]);
        $delay = '24h';
        $pricesAttributes = ['*'];
        $view = 'apps/_cisCountriesFormEditAfter';

        if ($application->other_type) {
            $delay = '72h';
            $application->time_delay = 73;
            $pricesAttributes = ['other_type_price', 'other_type_price_keywords'];
            $view = 'apps/_cisCountriesFormEditAfterOtherType';

            $prices = AppPrice::getPrices($pricesAttributes);
            $can_be_changed = $application->canBeChanged();

            return view()->make($view, compact(
                'application',
                'settings',
                'prices',
                'delay',
                'install_limit',
                'user_type',
                'can_be_changed'
            ));
        }

        $application->time_delay = 24;
        switch ($request->get('time_delay')) {
            case 48 :
                $delay = '48h';
                $application->time_delay = 48;
                break;
            case 72 :
                $delay = '72h';
                $application->time_delay = 72;
                break;
            case  72 + 1:
                $delay = '72h';
                $application->time_delay = 73;
                $pricesAttributes = ['other_type_price', 'other_type_price_keywords'];
                $view = 'apps/_cisCountriesFormEditAfterOtherType';
                break;
        }

        $group = $request->get('group', 'cis');

        $prices = AppPrice::getPrices($pricesAttributes);
        $can_be_changed = $application->canBeChanged();

        if ($group != 'cis') {
            $view = 'apps/_otherCountriesFormEdit';

            return view()->make($view, compact(
                'application',
                'settings',
                'prices',
                'delay',
                //'install_limit',
                'user_type',
                'can_be_changed'
            ));
        }

        return view()->make($view, compact(
            'application',
            'settings',
            'prices',
            'delay',
//            'install_limit',
            'user_type',
            'can_be_changed'
        ));
    }

    public function getCities(Country $country, string $group): JsonResponse
    {
        $lang = app()->getLocale();
        $cities = new Collection();
        if ($group === 'cis') {
            $cities = $country->cities()->get()->pluck("city_name_$lang", 'id');
        }
        $cities->prepend(trans('labels.all.cities'), 0);

        return response()->json($cities);
    }

    public function update(Request $request, Task $application): RedirectResponse
    {
        $user = $this->auth_user;

        if ($application->canceled) {
            Flash::error('<div style="font-size: 12pt">' . trans('validation.already_canceled') . '</div>');

            return redirect()->back();
        }

        if ($request->get('limit') < Settings::getInstance()->getAttributeValue('application_downloads_min_limit')) {
            Flash::error('<div style="font-size: 12pt">' . trans('validation.install_limit') . '</div>');

            return redirect()->back();
        }

        // Application owner
        $manager = $application->user;

        // Surcharge from balance
        $surcharge = floatval($request->get('surcharge'));

        if ($surcharge && $manager->role !== Role::ADMIN_ROLE_ID && $user->role !== Role::ADMIN_ROLE_ID) {
            if ($surcharge > $manager->balance) {
                Flash::error('<div style="font-size: 12pt">' . trans('messages.not_enough_money')
                    . ' <a href="' . route('account::balance') . '"'
                    . ' class="alert-text-link">' . trans('labels.replenish') . '</a>'
                    . '</div>');

                return redirect()->back();
            }

            $manager->update([
                'balance' => $manager->balance - $surcharge,
            ]);

            $manager->balanceReplenishments()->create([
                'app_id' => $application->id,
                'amount' => -$surcharge
            ]);
        }

        // If admin check that app payed from manager balance
        if ($request->get('pay_manager')) {
            $selectedManager = User::find($request->get('user_id'));

            if ($selectedManager->role === Role::MANAGER_ROLE_ID) {
                if ($surcharge > $selectedManager->balance) {
                    Flash::error('<div style="font-size: 12pt">' . trans('messages.manager_not_enough_money') . '</div>');

                    return redirect()->back();
                }

                $selectedManager->update([
                    'balance' => $selectedManager->balance - $surcharge,
                ]);
            }
        }

        if ($request->input('top') == 1) {
            $application->fill([
                'top' => 1,
            ]);
        } else {
            $application->fill([
                'top' => 0,
            ]);
        }

        $application->fill([
            'done' => false,
        ]);

        if ($request->has('price2') && $request->input('price2')) {
            $request['price'] = $request->input('price2');
        }

        $input = $request->except(
            '_token',
            'amount',
            'package_name',
            'price_for_user',
            'install_price_for_user',
            'expected_price_for_user',
            'expected_price',
            'country',
            'city',
            'done',
            'price2',
            'min_tasks_limit_active',
            'user_id',
            'daily_budget',
            'daily_budget_amount',
            'daily_budget_installs_limit',
            'hourly_budget',
            'hourly_budget_amount',
            'hourly_budget_installs_limit',
            'surcharge',
            'review',
            'review_rates',
            'review_comments',
            'review_percent_rates',
            'review_percent_comments',
            'review_keywords',
            'review_stars',
            'clicks',
            'pay_manager',
            'top'
        );

        $input['custom_price'] = $input['custom_price'] == "false" ? 0 : 1;

        $input['package_name'] = self::getApplicationPackageName($request->get('package_name'));
        $input['tracking_service'] = filter_var($request->get('tracking_service'), FILTER_VALIDATE_BOOLEAN);
        if (false === $input['tracking_service']) {
            $input['tracking_link'] = null;
        }

        $application->fill($input);

        if ($user->hasRole('admin')) {
            $application->update([
                'done' => isset($request->done),
                'min_tasks_limit_active' => isset($request->min_tasks_limit_active),
                'description' => ''
            ]);
        }

        if ($request->has('user_id') && intval($request->input('user_id')) !== $application->user_id) {
            $application->user()->associate($request->input('user_id'));
        }

        $country_id = (int)$request->input('country');
        $city_id = (int)$request->input('city');
        $promotion = (int)$request->input('promotion_type');

        if ($request->has('country') && $country_id !== 0) {
            $country = Country::query()->find($country_id);
            $application->country()->associate($country);
        } else {
            $application->country()->dissociate();
            $application->city()->dissociate();
        }

        if ($city_id !== 0) {
            $city = City::query()->find($city_id);
            $application->city()->associate($city);
            if ($promotion !== Task::PROMOTION_BY_KEYWORDS) {
                $promotion = Task::PROMOTION_BY_CITY;
            }
        } else {
            $application->city()->dissociate();
        }

        $application->keywords = null;

        if ($promotion === Task::PROMOTION_BY_KEYWORDS) {
            $application->fill([
                'keywords' => serialize($input['keywords']),
                'type' => 1,
            ]);
        }

        if ($application->country_group) {
            if ($application->isCis()) {
                $suitableGroups = ['cis'];
            } else {
                $suitableGroups = array_keys(array_diff_key(Country::GROUPS, ['cis' => null]));
            }

            if (!in_array($input['country_group'], $suitableGroups)) {
                Flash::error('<div style="font-size: 12pt">' . trans('validation.grounty_group_failed') . '</div>');

                return redirect()->back();
            }
        }

        $application->fill([
            'promotion_type' => $promotion,
            'country_group' => $input['country_group'],
        ]);

        $daily_budget = filter_var($request->input('daily_budget'), FILTER_VALIDATE_BOOLEAN);
        $daily_budget_amount = $daily_budget ? $request->input('daily_budget_amount') : null;
        $daily_budget_installs_limit = $daily_budget ? $request->input('daily_budget_installs_limit') : null;

        $application->fill([
            'daily_budget' => $daily_budget,
            'daily_budget_amount' => $daily_budget_amount,
            'daily_budget_installs_limit' => $daily_budget_installs_limit,
        ]);

        $hourly_budget = filter_var($request->input('hourly_budget'), FILTER_VALIDATE_BOOLEAN);
        $hourly_budget_amount = $hourly_budget ? $request->input('hourly_budget_amount') : null;
        $hourly_budget_installs_limit = $hourly_budget ? $request->input('hourly_budget_installs_limit') : null;

        $application->fill([
            'hourly_budget' => $hourly_budget,
            'hourly_budget_amount' => $hourly_budget_amount,
            'hourly_budget_installs_limit' => $hourly_budget_installs_limit,
        ]);

        $description_active = filter_var($request->input('description_active'), FILTER_VALIDATE_BOOLEAN);
        $application->fill([
            'description' => $description_active ? $input['description'] : '',
            'description_active' => $description_active,
        ]);

        if (filter_var($request->review, FILTER_VALIDATE_BOOLEAN)) {
            $review = [
                'rates' => $request->get('review_rates', 0),
                'comments' => $request->get('review_comments', 0),
                'keywords' => serialize($request->get('review_keywords', [])),
                'stars' => $request->get('review_stars', 5),
            ];

            if ($application->review()->exists()) {
                $review = $application->review->fill($review);
                $review->save();
            } else {
                $application->review()->create($review);
            }
        } elseif ($application->has('review')) {
            $application->review()->delete();
        }

        $application->fill([
            'custom_price' => filter_var($input['custom_price'], FILTER_VALIDATE_BOOLEAN),
        ]);


        if ($application->time_delay == 73){
            $application->time_delay = 72;
            $application->other_type = true;
        } else {
            $application->other_type = false;
        }

        if (!$application->isCis() || $application->other_type == 1) {
            if (!$application->statistics()->exists()) {
                $application->statistics()->create();
            }
            $application->fill([
                'moderated' => false,
                'accepted' => false,
            ]);
        }

        $application->save();

        $application = Task::find($application->id);

        //$this->dispatch(new ApplicationSaved($application->fresh()));

        if ($request->deferred_start) {

            $now = Carbon::now();

            $job = (new AppDeferredStart($application))->delay($now->diffInMinutes($application->deferred_start) * 60);

            $this->dispatch($job);

            /*AppDeferredStart::dispatch($application->fresh())
                ->delay($application->deferred_start);*/
        }

        Flash::success('<div style="font-size: 12pt">' . trans('messages.app_updated', [
                'app_name' => '<span class="label label-info">' . $application->name . '</span>'
            ])
            . '</div>');

        return redirect()->route('apps::show', ['id' => $application->id]);
    }

    public function show(Task $application): View
    {
        $application->name = $application->title;
        $application->image = $application->image_url;
        $title = !empty($application->name) ? $application->name : config('app.name');

        if ($application->other_type == 1) {
            $application->load('statistics');
            $view = view('apps.showOther', compact('title', 'application'));

            return $view;
        }

        if ($application->isCis()) {
            /** @var Task $last_updated_task */
            $last_updated_task = $application->tasks()->latest()->first();

            // For statistics (for last 7 days)
            if ($last_updated_task) {
                $end = $last_updated_task->updated_at->endOfDay();
            } else {
                $end = Carbon::today()->endOfDay();
            }

            $dates = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $end->copy()->subDays($i);
                array_unshift($dates, $date);
            }

            $app_installs = [];
            $app_runs = [];
            for ($i = 0; $i < count($dates); $i++) {
                $app_runs[] = 0;
            }
            $app_runs_collections = [];
            $app_fails = [];

            /** @var Carbon $date */
            foreach ($dates as $index => $date) {
                $install_query = $application->tasks();

                $runs_query = clone $install_query;

                $date_string = $date->toDateString();

                $app_installs[] = $install_query
                    ->where('is_installed', 1)
                    ->whereDate('created_at', '=', $date_string)->count();

                $app_runs_collections[$index] = $runs_query
                    ->whereDate('last_open', '=', $date_string)->get(['times', 'failed_times']);
            }

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
            $chart->title(' ');
            $chart->elementLabel(' ');
            $chart->colors(['#9acae6', '#d69eba']);
            $chart->labels($dates);
            $chart->dataset(trans('labels.installs'), $app_installs);
            //$chart->dataset(trans('labels.runs'), $app_runs);

            $success_review = $application->tasks()
                ->whereHas('review', function (Builder $query) {
                    $query->where('state', '=', TaskReview::REVIEW_DONE);
                })->count();

            $success_comment = $application->tasks()
                ->whereHas('review', function (Builder $query) {
                    $query->where('state', '=', TaskReview::COMMENT_DONE);
                })->count();

           $reviews = [
                'success_review' => $success_review,
                'success_comment' => $success_comment,
            ];

            $view = view('apps.showCis', compact('title', 'application', 'reviews', 'chart'));
        } else {
            $application->load('statistics');
            $view = view('apps.showOther', compact('title', 'application'));
        }

        return $view;
    }

    public function getUsers(Task $application, Request $request): JsonResponse
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search');
        $sort = $request->get('sort') ?: 'ud';
        $order = $request->get('order') ?: 'desc';
        $app_tasks = $application->tasks()->where('is_accepted', 1)->with('user');
        if ($search) {
            $total = $app_tasks->search($search)->count();
            $rows = $app_tasks->search($search)->sort($sort, $order)->skip($offset)->take($limit)->get();
        } else {
            $total = $app_tasks->count();
            $rows = $app_tasks->sort($sort, $order)->skip($offset)->take($limit)->get();
        }

        return response()->json(compact('total', 'rows'));
    }

    public function payFromBalance(Task $application, CampaignServiceInterface $campaignService): JsonResponse
    {
        $user = $application->user;
        if ($user->id !== $this->auth_user->id) {
            session()->flash(
                'message', trans('messages.access_denied')
            );
            Flash::error('<div style="font-size: 12pt">' . trans('messages.access_denied') . '</div>');
            return response()->json([
                'error' => trans('messages.access_denied'),
                'url' => route('apps::index')
            ], 403);
        }

        $success = $campaignService->payFromBalance($application, $user);

        if (!$success) {
            session()->flash(
                'message', trans('messages.not_enough_money')
            );

            Flash::error('<div style="font-size: 12pt">' . trans('messages.not_enough_money')
                . ' <a href="' . route('account::balance') . '"'
                . ' class="alert-text-link">' . trans('labels.replenish') . '</a>'
                . '</div>');

            return response()->json([
                'error' => 'insufficient_funds',
                'url' => \URL::previous()
            ], 416);
        }

        session()->flash(
            'message', '<div style="font-size: 12pt">'
            . trans('messages.app_success_moderating', ['id' => $application->id]) . '</div>'
        );
        Flash::success('<div style="font-size: 12pt">'
            . trans('messages.app_success_moderating', ['id' => $application->id]) . '</div>');

        return response()->json(['url' => route('apps::index')], 200);
    }

    public function getDataForChart(Request $request): \Illuminate\Contracts\View\View
    {
        /** @var Task $application */
        $application = Task::query()->find((int)$request->get('app_id'));

        $date_to = !empty($request->get('date_to'))
            ? Carbon::createFromFormat('d-m-Y', $request->get('date_to'))
                ->endOfDay()
            : Carbon::today()->endOfDay();

        $date_from = !empty($request->get('date_from'))
            ? Carbon::createFromFormat('d-m-Y', $request->get('date_from'))
                ->startOfDay()
            : Carbon::createFromFormat('d-m-Y', $request->get('date_to'))
                ->endOfDay()->subDays(6);

        $dates = DateHelper::getDatesBetween($date_from, $date_to);

        $app_installs = [];
        $app_runs = [];

        /** @var Carbon $date */
        foreach ($dates as $index => $date) {
            $app_installs[] = $application->tasks()
                ->where('is_installed', 1)
                ->whereDate('created_at', '=', $date->toDateString())->count();

            $app_runs[] = $application->tasks()
                    ->whereDate('last_open', '=', $date->toDateString())->sum('times') ?? 0;

            $dates[$index] = $date->format('d/m/Y'); // Format to output
        }

        /** @var Multi $chart */
        $chart = Charts::multi('line', 'highcharts');
        $chart->title(' ');
        $chart->elementLabel(' ');
        $chart->colors(['#9acae6', '#d69eba']);
        $chart->labels($dates);
        $chart->dataset(trans('labels.installs'), $app_installs);
        $chart->dataset(trans('labels.runs'), $app_runs);

        return \View::make('partials._chart', compact('chart'));
    }

    public function changesHistory(Task $application)
    {
        $changes_history = DB::table('apps_logs')
            ->where('app_id', '=', $application->id)
            ->orderByDesc('created_at')
            ->get();

        // Reformat date and process amount to correct currency
        foreach ($changes_history as $change) {
            $date = Carbon::parse($change->created_at);
            $change->created_at = $date->format('H:i:s d-m-Y');
            $change->country = is_null($change->country_id) ? '' : Country::find($change->country_id)->getNameAttribute();
            $change->city = is_null($change->city_id) ? '' : City::find($change->city_id)->getNameAttribute();

            $delays = [
                24 => trans('labels.24_h'),
                48 => trans('labels.48_h'),
                72 => trans('labels.72_h'),
            ];
            $change->time_delay = $delays[$change->time_delay];
            $change->keywords = unserialize($change->keywords);
        }

        return \View::make('partials._appChangesHistory', compact('changes_history'));
    }

    public function moderating(): View
    {
        $apps = Task::paid()->whereModerated(false)->get()
            ->map( function ($app) {
                $app->name = $app->title;
                $app->image = $app->image_url;
                return $app;
            })
            ->toJson();

        return view('apps.moderating', compact('apps'));
    }

    public function changeAppStatus(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $app = Task::query()->find($request->get('id'));

            if ($app->paid && $app->moderated && $app->accepted && !$app->done) {
                $app->update(['active' => !$app->active]); // Toggle status

                if ($app->active && $app->country_group === 'cis' && $app->other_type == 0) {
                    $this->dispatch(new SendNewTaskNotification($app));
                }

            }

            return response()->json(['active' => $app->active]);
        }

        throw new HttpRequestException();
    }

    public function moderate(Request $request): JsonResponse
    {
        /** @var Task $application */
        $application = Task::query()->find($request->id);
        $reason = filter_var($request->reason, FILTER_VALIDATE_BOOLEAN);

        $application->update([
            'moderated' => true,
            'accepted' => $reason,
        ]);

        $amount_for_user_left = $application->amount_for_user - $application->amount_wasted;

        if (false === $reason) {
            /** @var User $owner */
            $owner = $application->user;
            $owner->update(['balance' => $owner->balance + $amount_for_user_left]); // Return money on user balance
        }

        return response()->json([], 200);
    }

    public function delete(Task $application): void
    {
        if ($application->paid && !$application->moderated) {
            throw new AccessDeniedHttpException('Unable to delete application while on moderation');
        }

        if ($application->paid && (!$application->canceled && !$application->done)) {
            // Return unspent money on User balance
            $cash_back = $application->amount_for_user - $application->amount_wasted;

            $application->user()->update([
                'balance' => $application->user->balance + $cash_back,
            ]);

        }

        $application->delete();
    }

    public function moderatingReviewsAdvert(): ViewMake
    {
        $reviews = TaskReview::onModeration()->whereNull('user_task_ud')->get();

        return \View::make('partials._moderatingReviewItems', compact('reviews'));
    }

    public function moderatingReviews(Task $application): View
    {
        $reviews = $application->reviewTasks()->whereIn('state', [
            TaskReview::REVIEW_MODERATING,
            TaskReview::COMMENT_MODERATING,
        ])->get();

        return \View::make('partials._moderatingReviewItems', compact('reviews'));
    }

    public function moderateReview(Request $request): JsonResponse
    {
        $reason = filter_var($request->get('reason', false), FILTER_VALIDATE_BOOLEAN);

        /** @var TaskReview $review */
        $review = TaskReview::query()->find($request->get('id'));

        /** @var Settings $rewards */
        $rewards = Settings::getInstance(['review_price', 'review_comment_price', 'rate']);

        switch ($review->state) {
            case TaskReview::REVIEW_MODERATING:
                $new_state = $reason ? TaskReview::REVIEW_DONE : TaskReview::REVIEW_FAILED;
                $reward = $rewards->review_price;
                break;
            case TaskReview::COMMENT_MODERATING:
                $new_state = $reason ? TaskReview::COMMENT_DONE : TaskReview::COMMENT_FAILED;
                $reward = $rewards->review_comment_price;
                break;
            default:
                $new_state = $review->state;
                $reward = 0;
        }

        $review->update([ 
            'state' => $new_state,
        ]);

        $review = TaskReview::find($review->id);

        $user_task = $review->user->tasks()->wherePivot('ud', $review->user_task_ud)->first();

        if ($review->state == TaskReview::REVIEW_DONE || $review->state == TaskReview::COMMENT_DONE) {

            $rate = $rewards->rate;

            $user_task->pivot->is_rating_available = 3;
            $user_task->pivot->save();

            $review->user()->update([
                'balance' => $review->user->balance + $reward * $rate,
            ]);

            $this->dispatch(new SendDoneReviewNotification($review->user, $user_task->id));
        }

        if ($review->state == TaskReview::REVIEW_FAILED || $review->state == TaskReview::COMMENT_FAILED) {
            $user_task->pivot->is_rating_available = 1;
            $user_task->pivot->save();

            $review->delete();
        }

        return response()->json([], 200);
    }

}
