<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Http\Requests\UserRequest;
use App\Jobs\SendCustomNotification;
use App\Jobs\SendCustomNotificationToDevice;
use App\Jobs\SendTaskUserNotification;
use App\Models\Award;
use App\Models\Role;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBalanceReplenishment;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserController extends BaseController
{

    public function __construct(CurrencyServiceInterface $currencyService)
    {
        parent::__construct($currencyService);
        $this->middleware('editor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $title = trans('labels.users');
        $users = User::query()->count();
        $roles = Role::all(['id', 'name', 'display_name_en']);

        return view('users.index', compact('title', 'users', 'roles'));
    }

    /**
     * Get all users in JSON with specified parameters:
     * offset, limit, search.
     * Needed for server side table pagination
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $search = $request->get('search');
        $promo_code = $request->get('promocode');
        // For editor display only users of application
        $role_id = $this->is_editor ? Role::USER_ROLE_ID : intval($request->get('role'));
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $sort = $sort === 'balance_formatted' ? 'balance' : $sort;

        if ($role_id !== 0) {
            /** @var Role $role */
            $role = Role::query()->find($role_id);

            $query = $role->users();
        } else {
            $query = User::query();
        }

        if (!empty($promo_code)) {
            $query->where('promo_code_first', '=', $promo_code)
                ->orWhere('promo_code_second', '=', $promo_code);
        }

        if ($search) {
            $query = $query->searchByUserIdentifier($search);
            $total = $query->count();
            $rows = $query->sort($sort, $order)->skip($offset)->take($limit)->get();
        } else {
            $total = $query->count();
            $rows = $query->skip($offset)->take($limit)->orderBy($sort, $order)->get();
        }

        return response()->json(compact('total', 'rows'));
    }

    /**
     * Display user create page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(): View
    {
        $title = trans('labels.user_create');
		if(app()->getLocale() == 'ru')
		{
			$roles = Role::query()->pluck('display_name', 'id');
		} else {
			$roles = Role::query()->pluck('display_name_en', 'id');
		}

        return view('users.create', compact('title', 'roles'));
    }

    /**
     * Creating user
     *
     * @param UserRequest|Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request): RedirectResponse
    {
		//dd($request->all(),$request->input('name'));
        /** @var User $user */
        $user = new User();
			
			$user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'token' => str_random(),
            'promo_code_first' => str_random(),
            'promo_code_second' => str_random(),
        ]);
$user->save();
        $user->roles()->attach(intval($request->input('role')));
$user->save();
        Flash::success(trans('messages.user_successfully_created'));

        return redirect('users');
    }

    /**
     * Update user info
     *
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $old_balance = $user->balance;
        $new_balance = floatval($request->input('balance'));
        if ($old_balance !== $new_balance) {
            $diff = $new_balance - $old_balance;
            $user->balanceReplenishments()->create([
                'amount' => $diff,
            ]);
        }
        $user->update([
            'name' => empty($request->get('name')) ? '' : $request->get('name'),
            'email' => empty($request->get('email')) ? null : $request->get('email'),
            'balance' => $request->get('balance'),
            'banned' => filter_var($request->get('banned'), FILTER_VALIDATE_BOOLEAN),
        ]);

        if ($this->is_admin && $request->has('role')) {
            $user->roles()->sync([(int)$request->input('role')]);
        }

        Flash::success(trans('messages.user_successfully_edited'));

        return redirect()->back();
    }

    /**
     * Delete user
     *
     * @param Request $request
     * @param User $user
     *
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
		\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $user->delete();
        if ($request->wantsJson()) {
            return response()->json([], 204);
        }
		\DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Flash::success(trans('messages.user_successfully_deleted'));

        return redirect()->route('users::index');
    }

    /**
     * @param User $user
     *
     * @return View|RedirectResponse
     */
    public function show(User $user)
    {
        if ($this->is_editor && !$user->hasRole('user')) {
            Flash::error(trans('messages.access_denied'));

            return redirect()->back();
        }

        $title = trans('labels.user') . ' ' . $user->device_token;

        $referrals_count = $user->referrals()->count();
        $tasks_count = $user->tasks()->count();
        $awards_count = $user->awards()->count();
        $transactions_count = $user->transactions()->count();
        $roles = Role::query()->pluck('display_name_en', 'id');

        if ($this->is_admin) {
            $replenishment_history = $user->balanceReplenishments()
                ->get(['amount', 'ik_inv_id', 'unitpayId', 'created_at', 'app_id']);

            // Reformat date and process amount to correct currency
            /*$replenishment_history->map(function (UserBalanceReplenishment $replenishment) {
                $replenishment->amount = $this->currency->convertFromRub($replenishment->amount);

                return $replenishment;
            });*/
        } else {
            $replenishment_history = null;
        }

        return view('users.view', compact(
            'title',
            'user',
            'referrals_count',
            //'methods',
            'tasks_count',
            'awards_count',
            'transactions_count',
            'roles',
            'replenishment_history'
        ));
    }

    public function getReferralsView(User $user): View
    {
        $title = trans('labels.user') . ' ' . $user->device_token . ' - ' . trans('labels.referrals');
        $count = $user->referrals()->count();
        $roles = User::ROLES;

        return view('users.stats.referrals', compact(
            'title',
            'user',
            'count',
            'roles'
        ));
    }


    /**
     * @param Request $request
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferrals(Request $request, User $user): JsonResponse
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $filter = $request->get('filter');
        $sort = $request->get('sort') ?: 'id';
        $order = $request->get('order') ?: 'desc';
        $query = $user->referrals();
        $sort = $sort === 'balance_formatted' ? 'balance' : $sort;
        if ($filter) {
            $query = $query->where(function ($query) use ($filter) {
                /** @var User $query */
                $query->filter($filter);
            });
            $total = $query->count();
            $rows = $query->sort($sort, $order)->skip($offset)->take($limit)->get();
        } else {
            $total = $query->count();
            $rows = $query->skip($offset)->sort($sort, $order)->take($limit)->get();
        }

        return response()->json(compact('total', 'rows'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTransactionsView(User $user): View
    {
        $title = trans('labels.user') . ' ' . $user->device_token . ' - ' . trans('labels.buttons.transactions');
        $count = $user->transactions()->count();
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
        $counts = [
            Transaction::STATUS_OK => [
                'count' => $user->transactions()->getSuccessfulCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_OK)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_OK)['class'],
            ],
            Transaction::STATUS_SENT => [
                'count' => $user->transactions()->getSentCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_SENT)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_SENT)['class'],
            ],
            Transaction::STATUS_REJECTED => [
                'count' => $user->transactions()->getRejectedCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_REJECTED)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_REJECTED)['class'],
            ],
            Transaction::STATUS_PENDING => [
                'count' => $user->transactions()->getPendingCount()->count(),
                'label' => Transaction::getStatusForView(Transaction::STATUS_PENDING)['label'],
                'class' => Transaction::getStatusForView(Transaction::STATUS_PENDING)['class'],
            ],
        ];

        return view('users.stats.transactions', compact(
            'title',
            'user',
            'statuses',
            'methods',
            'count',
            'counts'
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactions(Request $request, User $user): JsonResponse
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $sort = $request->get('sort') ?: null;
        $order = $request->get('order') ?: 'desc';
        $status = $request->get('status') ?? 'all';

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
            $query = $user->transactions()->searchByStatus($status);
        } else {
            $query = $user->transactions();
        }

        if (is_null($date_from)) {
            $query->where('created_at', '<', $date_to);
        } else {
            $query->whereBetween('created_at', [$date_from, $date_to]);
        }

        $total = $query->count();
        $rows = $query->sort($sort, $order)->skip($offset)->take($limit)->get();

        return response()->json(compact('total', 'rows'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTasksView(User $user): View
    {
        $title = trans('labels.user') . ' ' . $user->device_token . ' - ' . trans('labels.tasks.tasks');
        $count = $user->tasks()->count();

        return view('users.stats.tasks', compact(
            'title',
            'user',
            'count'
        ));
    }

    /**
     * @param Request $request
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTasks(Request $request, User $user): JsonResponse
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search');
        $sort = $request->get('sort') ?: 'id';
        $order = $request->get('order') ?: 'desc';
        /** @var \Illuminate\Database\Eloquent\Builder|Task $query */
        $query = $user->tasks();
        if ($search) {
            $total = $query->search($search)->count();
            $rows = $query->with('app')->search($search)->sort($sort, $order)->skip($offset)->take($limit)->get();
        } else {
            $total = $query->count();
            $rows = $query->with('app')->sort($sort, $order)->skip($offset)->take($limit)->get();
        }

        return response()->json(compact('total', 'rows'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAwardsView(User $user): View
    {
        $title = trans('labels.user') . ' ' . $user->device_token . ' - ' . trans('labels.awards');
        $count = $user->awards()->count();
        $referralSystems = [
            0 => trans('labels.tasks.tasks'),
            User::REFERRAL_SYSTEM_FIRST => trans('labels.referral_first'),
            User::REFERRAL_SYSTEM_SECOND => trans('labels.referral_second'),
            Award::AWARD_VIDEO => trans('labels.award_standard_task_video_short'),
            Award::AWARD_REFILL => trans('labels.refill'),
        ];
        $referralSystems = array_merge($referralSystems, Award::OFFERS);

        return view('users.stats.awards', compact(
            'title',
            'user',
            'count',
            'referralSystems'
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAwards(Request $request, User $user): JsonResponse
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $filter = $request->get('filter');
        $sort = $request->get('sort') ?: 'id';
        $order = $request->get('order') ?: 'desc';
        /** @var \Illuminate\Database\Eloquent\Builder|Award $query */
        $query = $user->awards();
        switch ($sort) {
            case 'referral_system_label':
                $sort = 'referral_system';
                break;
            case 'amount_formatted':
                $sort = 'amount';
                break;
        }
        if ($filter) {
            $total = $query->filter($filter)->count();
            $rows = $query->with('app')->filter($filter)->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        } else {
            $total = $query->count();
            $rows = $query->with('app')->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        }

        return response()->json(compact('total', 'rows'));
    }

    /**
     * Send message to all users
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPush(Request $request): JsonResponse
    {
        try {
            $message = $request->get('message');

            $this->dispatch(new SendCustomNotification($message));

            return response()->json(trans('messages.push_notification_sent'), 200);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();

            return response()->json($message, 400);
        }
    }

    public function sendAppPush(Request $request): JsonResponse
    {
        try {
            $message = $request->get('message');
            $task = Task::find($request->get('id'));

            $this->dispatch(new SendTaskUserNotification($message, $task));

            return response()->json(trans('messages.push_notification_sent'), 200);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();

            return response()->json($message, 400);
        }
    }

    /**
     * Send message to specified User
     *
     * @param User $user
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPushToUser(User $user, Request $request): JsonResponse
    {
        $message = $request->get('message');

        if ($user->fcm_token) {
            $this->dispatch(new SendCustomNotificationToDevice($message, $user->fcm_token));
        }

        return response()->json(trans('messages.push_notification_sent'), 200);
    }

    public function event(): View
    {
        $title = trans('labels.users');
        $users = User::whereEvent(1)->get();
        $roles = Role::all(['id', 'name', 'display_name']);

        return view('users.event', compact('title', 'users', 'roles'));
    }

    public function getUsersEvent(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $search = $request->get('search');
        $promo_code = $request->get('promocode');
        // For editor display only users of application
        $role_id = $this->is_editor ? Role::USER_ROLE_ID : intval($request->get('role'));
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $sort = $sort === 'balance_formatted' ? 'balance' : $sort;

        if ($role_id !== 0) {
            /** @var Role $role */
            $role = Role::query()->find($role_id);

            $query = $role->users()->whereEvent(1);
        } else {
            $query = User::query()->whereEvent(1);
        }

        if (!empty($promo_code)) {
            $query->where('referral_first_code', '=', $promo_code)
                ->orWhere('referral_second_code', '=', $promo_code);
        }

        if ($search) {
            $query = $query->searchByUserIdentifier($search);
            $total = $query->count();
            $rows = $query->sort($sort, $order)->skip($offset)->take($limit)->get();
        } else {
            $total = $query->count();
            $rows = $query->skip($offset)->take($limit)->orderBy($sort, $order)->get();
        }

        return response()->json(compact('total', 'rows'));
    }
}