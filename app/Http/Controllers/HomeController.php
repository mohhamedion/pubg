<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Settings;
use App\Models\Task;
use App\Models\TaskReview;
use App\Models\UserTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;
use Flash;
use App\Contracts\Services\CurrencyServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends BaseController
{
    public function __construct(CurrencyServiceInterface $currencyService)
    {
        $this->middleware('web');

        parent::__construct($currencyService);
    }

    public function index(): View
    {
        $title = trans('labels.project_title');

        /*if ($this->is_editor) {
            return resolve(TransactionsController::class)->index();
        }*/
        $auth_user = Auth::user();

        $is_admin = false;
        $is_manager = false;
        $is_editor = false;

        if (!is_null($auth_user)) {
            switch ($auth_user->getRoleAttribute()) {
                case Role::ADMIN_ROLE_ID:
                    $is_admin = true;
                    break;
                case Role::MANAGER_ROLE_ID:
                    $is_manager = true;
                    break;
                case Role::EDITOR_ROLE_ID:
                    $is_editor = true;
                    break;
            }
        }

        return view('pages.home', compact('title', 'is_admin', 'is_manager', 'is_editor'));
    }

    public function changeLocale(Request $request): void
    {
        $locale = $request->get('locale');
        Session::put('locale', $locale);
        //session()->push('locale', $locale);
    }

    public function changeTheme(Request $request): void
    {
        $theme = $request->get('theme') === 'light' ? 'dark' : 'light';
        Session::put('theme', $theme);
    }

    public function changeCurrency(Request $request): void
    {
        $country = $request->get('currency');
        Session::put('country', $country);
    }

    public function moderatingReviews(): View
    {
        $title = trans('labels.moderate_reviews');
        $application = null;

        $advert_reviews_count = TaskReview::onModeration()->whereNull('user_task_ud')->count();

        $applications = Task::whereHas('reviewTasks', function (Builder $query) {
            $query->whereIn('state', [
                TaskReview::REVIEW_MODERATING,
                TaskReview::COMMENT_MODERATING,
            ]);
        })->get(['id', 'title']);

        $applications = $applications->map(function (Task $app) {
            $reviews_count = $app->reviewTasks()->whereIn('state', [
                TaskReview::REVIEW_MODERATING,
                TaskReview::COMMENT_MODERATING,
            ])->count();

            $app->setAttribute('reviews_count', $reviews_count);

            $app->name = $app->title;

            return $app;
        });

        return view('apps.moderatingReviews', compact('title', 'application', 'advert_reviews_count', 'applications'));
    }

    public function agreement(): View
    {
        $title = trans('labels.nav.agreement');

        $agreement_ru = Settings::getInstance()->getAttributeValue('agreement_ru');
        $agreement_en = Settings::getInstance()->getAttributeValue('agreement_en');

        $agreement = [
            'ru' => $agreement_ru,
            'en' => !empty($agreement_en) ? $agreement_en : $agreement_ru,
        ];

        return view('pages.agreement', compact('title', 'agreement'));
    }

    public function updateAgreement(Request $request): RedirectResponse
    {
        Settings::query()->update([
            'agreement_ru' => $request->input('agreement_ru'),
            'agreement_en' => $request->input('agreement_en'),
        ]);

        Flash::success(trans('messages.settings_successfully_created'));

        return redirect()->back();
    }

    public function restricted(): View
    {
        if (isset($this->auth_user) && !$this->auth_user->active) {
            return view('pages.restricted');
        }

        throw new NotFoundHttpException();
    }

    public function banned(): View
    {
        if (!$this->auth_user->active) {
            return view('pages.banned');
        }

        throw new NotFoundHttpException();
    }
}
