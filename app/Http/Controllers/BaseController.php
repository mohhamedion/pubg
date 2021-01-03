<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\Article;
use App\Models\Role;
use App\Models\ServiceRequestType;
use App\Models\Task;
use App\Models\TaskReview;
use App\Models\Transaction;
use Auth;
use Request;
use GeoIP;
use Session;
use DB;

class BaseController extends Controller
{
    protected $auth_user;

    protected $is_admin;

    protected $is_manager;

    protected $is_editor;

    protected $currency;

    public function __construct(CurrencyServiceInterface $currencyService)
    {
        $auth_user = Auth::user();

        $this->currency = $currencyService->getCurrency();

        try {
            $country = GeoIP::getLocation(Request::ip())['country'];
        } catch (Exception $exception) {
            $country = 'Russia';
        }

        $selected_currency = Session::get('country') ?? $country;
        $theme = Session::get('theme') ? Session::get('theme') : 'light';

        if (!in_array($selected_currency, $currencyService->getCurrencies())) {
            $selected_currency = 'Russia';
        }

        $currencies = [
            'USA' => trans('labels.currency.USA'),
            'Russia' => trans('labels.currency.Russia')
        ];
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

            $this->auth_user = $auth_user;
            $this->is_admin = $is_admin;
            $this->is_manager = $is_manager;
            $this->is_editor = $is_editor;
        }

        $moderating_reviews = TaskReview::onModeration()->count();
        $moderating_apps = Task::paid()->whereModerated(false)->count();
        $pending_transactions = Transaction::getPendingCount()->count();
        $special_offers = DB::table('user_special_offer_pivot')->count();

        /** @var ServiceRequestType $top */
        $top = ServiceRequestType::whereName('top')->firstOrCreate(['name' => 'top']);
        /** @var ServiceRequestType $aso */
        $aso = ServiceRequestType::whereName('aso')->firstOrCreate(['name' => 'aso']);
        /** @var ServiceRequestType $comments */
        $comments = ServiceRequestType::whereName('comments')->firstOrCreate(['name' => 'comments']);

        $requests_top = $top->requests()->count();
        $requests_aso = $aso->requests()->count();
        $requests_comments = $comments->requests()->count();

        if ($is_manager) {
            $read_articles = $auth_user->readArticles()->pluck('article_id');
            $unread_articles = Article::whereNotIn('id', $read_articles)->count();
        } else {
            $unread_articles = 0;
        }

        view()->share([
            'auth_user' => $auth_user,
            'is_admin' => $is_admin,
            'is_manager' => $is_manager,
            'is_editor' => $is_editor,
            'country' => $country,
            'currency' => $this->currency,
            'currencies' => $currencies,
            'selected_currency' => $selected_currency,
            'moderating_reviews' => $moderating_reviews,
            'moderating_apps' => $moderating_apps,
            'pending_transactions' => $pending_transactions,
            'theme' => $theme,
            'special_offers' => $special_offers,
            'requests_aso' => $requests_aso,
            'requests_top' => $requests_top,
            'requests_comments' => $requests_comments,
            'unread_articles' => $unread_articles,
            /*'notificationActive' => $notificationActive,
            'headerNotification' => $headerNotification,
            'collapsedMenu' => $collapsedMenu*/
        ]);
    }
}
