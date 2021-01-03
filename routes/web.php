<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

Route::get('viewed', 'EmailCheckController@views');
Route::get('clicked', 'EmailCheckController@links');
Route::get('register/manager', 'EmailCheckController@registerManager');
Route::get('restricted', 'HomeController@restricted')->name('restricted');
Route::get('not-active', 'HomeController@notActive')->middleware('auth');
Route::get('banned', 'HomeController@banned')->middleware('auth')->name('banned');
Route::get('account/balance/replenish/interact', 'AccountController@replenishmentInteract')
    ->name('account::balance.replenishment.interact');
Route::get('account/balance/status', 'AccountController@postReplenishment')
    ->name('account::balance.replenishment');
Route::auth();

if(app()->getLocale() == 'ru')
	Session::put('locale', 'en');

Route::group([
    'middleware' => [
        'auth',
        'isBanned',
        'admins'
    ],
], function () {
	
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('locale', 'HomeController@changeLocale')->name('change_locale');
    Route::post('currency', 'HomeController@changeCurrency')->name('change_currency');
    Route::get('themes/change', 'HomeController@changeTheme')->name('change_theme');
    //Route::get('country/{group}', 'AppController@getCountries');
    Route::get('country/{country}/{group}/cities', 'AppController@getCities');
    Route::get('reviews/moderate', 'HomeController@moderatingReviews')->name('reviews_moderate');
    Route::get('reviews', 'AppController@moderatingReviewsAdvert')->middleware('editor');
    Route::get('{application}/reviews', 'AppController@moderatingReviews')->name('reviews')
        ->middleware('editor');
    Route::post('reviews/moderate', 'AppController@moderateReview')->name('put.moderate')
        ->middleware('editor');

    Route::group(['prefix' => 'settings', 'as' => 'settings::'], function () {
        Route::get('/', 'SettingsController@index')->name('index');
        Route::patch('/', 'SettingsController@update')->name('patch');
    });

    Route::group(['prefix' => 'account', 'as' => 'account::'], function () {
        Route::get('/', 'AccountController@index')->name('index');
        Route::patch('/', 'AccountController@update')->name('patch.index');
        Route::patch('password', 'AccountController@updatePassword')->name('patch.password');
        Route::get('balance', 'AccountController@balance')->name('balance');
        Route::post('balance', 'AccountController@balanceReplenishment')->name('post.balance');
    });

    Route::group(['prefix' => 'users', 'as' => 'users::'], function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('event', 'UserController@event')->name('event');
        Route::get('users', 'UserController@getUsers')->name('getUsers');
        Route::get('event/users', 'UserController@getUsersEvent')->name('getUsersEvent');
        Route::put('edit/{user}', 'UserController@update')->name('update');
        Route::delete('edit/{user}', 'UserController@destroy')->name('delete');
        Route::get('create', 'UserController@create')->name('create');
        Route::post('store', 'UserController@store')->name('store');
        Route::post('send-push', 'UserController@sendPush')->name('send-push');
        Route::post('send-app-push', 'UserController@sendAppPush')->name('send-app-push');
        Route::group(['prefix' => 'show/{user}', 'as' => 'show::'], function () {
            Route::get('/', 'UserController@show')->name('index');
            Route::get('info/referrals', 'UserController@getReferralsView')->name('referralsView');
            Route::get('info/transactions', 'UserController@getTransactionsView')->name('transactionsView');
            Route::get('info/tasks', 'UserController@getTasksView')->name('tasksView');
            Route::get('info/awards', 'UserController@getAwardsView')->name('awardsView');
            Route::get('referrals', 'UserController@getReferrals')->name('referrals');
            Route::get('transactions', 'UserController@getTransactions')->name('transactions');
            Route::get('tasks', 'UserController@getTasks')->name('tasks');
            Route::get('awards', 'UserController@getAwards')->name('awards');
            Route::post('send-push', 'UserController@sendPushToUser')->name('send-push');
        });
    });


    Route::group(['prefix' => 'withdraw','as' => 'withdraw::'], function () {
        Route::get('/', 'PointsWithdrawsController@index')->name('index');
        Route::get('/history', 'PointsWithdrawsController@history')->name('history');
        Route::get('subStractPoints/{request_id}', 'PointsWithdrawsController@subStractPoints')->name('subStractPoints');
        Route::get('withdraw', 'PointsWithdrawsController@getRequests')->name('getRequests');

    });




     Route::group(['prefix' => 'questions','as' => 'questions::'], function () {
        Route::get('/', 'QuestionsController@index')->name('index');
        Route::post('/', 'QuestionsController@store')->name('store');

        Route::get('/create', 'QuestionsController@create')->name('create');
        Route::get('/edit/{quizz_id}', 'QuestionsController@edit')->name('edit');

        Route::post('/edit/{quizz_id}', 'QuestionsController@update')->name('update');
        Route::get('/delete/{quizz_id}', 'QuestionsController@delete')->name('delete');
        

    });


    Route::group(['prefix' => 'partners', 'middleware' => ['adminOnly'] , 'as' => 'partners::' ], function () {
        Route::get('/', 'PartnerController@index')->name('index');
        Route::get('{partner}/top', 'PartnerController@updateTop')->name('top');
        Route::get('{partner}/available', 'PartnerController@updateAvailable')->name('available');
    });

    Route::group(['prefix' => 'videos','middleware' => ['adminOnly'], 'as' => 'videos::' ], function () {
        Route::get('/', 'VideoController@index')->name('index');
        Route::get('{video}/top', 'VideoController@updateTop')->name('top');
        Route::get('{video}/available', 'VideoController@updateAvailable')->name('available');
    });

    Route::group(['prefix' => 'apps', 'as' => 'apps::'], function () {
        Route::get('/', 'AppController@index')->name('index');
        Route::post('/', 'AppController@changeAppStatus');
        Route::get('data', 'AppController@getData')->name('get.data');
        Route::get('create', 'AppController@create')->name('create');
        Route::post('store', 'AppController@store')->name('store');
        Route::get('edit/{application}', 'AppController@edit')->name('edit');
        Route::get('edit/{application}/load', 'AppController@getCampaignCustomParameters');
        Route::get('edit/{application}/load/after', 'AppController@getCustomParametersForCis');
        Route::post('edit/{application}', 'AppController@update')->name('update');
        Route::delete('edit/{application}', 'AppController@delete');
        Route::get('android-info', 'AppController@getAndroidInfo');
        Route::get('cities/{country}', 'AppController@getCities');
        Route::get('show/{application}', 'AppController@show')->name('show');
        Route::post('show/{application}/statistics', 'AppStatisticsController@update')->name('statistics.update')->middleware('adminOnly');
        Route::get('show/{application}/users', 'AppController@getUsers')->name('users');
        Route::post('cancel/{application}', 'AppController@cancel')->name('cancel');
        Route::get('moderating', 'AppController@moderating')->name('moderating')->middleware('adminOnly');
        Route::put('moderating', 'AppController@moderate')->name('put.moderating')->middleware('adminOnly');
        Route::post('{application}/pay', 'AppController@payFromBalance')->name('pay_balance');
        Route::get('data/chart', 'AppController@getDataForChart');
        Route::get('history/{application}', 'AppController@changesHistory')->name('changes_history');
    });

    Route::group(['prefix' => 'transactions', 'middleware' => ['editor'], 'as' => 'transactions::'], function () {
        Route::get('/', 'TransactionsController@index')->name('index');
        Route::get('get', 'TransactionsController@get')->name('get');
        Route::get('edit/{transaction}', 'TransactionsController@edit')->name('edit');
        Route::post('edit/{transaction}', 'TransactionsController@update')->name('update');
        Route::post('restore/{transaction}', 'TransactionsController@restore')->name('restore');
    });

    Route::group(['prefix' => 'special-offers', 'as' => 'special_offers::'], function () {
        Route::get('/', 'SpecialOffersController@index')->name('index');
        Route::get('create', 'SpecialOffersController@create')->name('create');
        Route::post('store', 'SpecialOffersController@store')->name('store');
        Route::get('{offer}', 'SpecialOffersController@show')->name('show');
        Route::get('edit/{offer}', 'SpecialOffersController@edit')->name('edit');
        Route::patch('update/{offer}', 'SpecialOffersController@update')->name('update');
        Route::delete('delete/{offer}', 'SpecialOffersController@destroy')->name('delete');
        Route::post('pay-balance', 'SpecialOffersController@payFromBalance')->name('pay-balance');
        Route::delete('delete/{user_offer}/user', 'SpecialOffersController@userDetach')->name('user_destroy');
    });

    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
        Route::get('/', 'ArticleController@index')->name('index');
        Route::get('show/{article}', 'ArticleController@show')->name('show');
    });

    Route::get('agreement', 'HomeController@agreement')->name('agreement.show');
    Route::put('agreement', 'HomeController@updateAgreement')->name('agreement.update');

    Route::group(['prefix' => 'payment-systems', 'as' => 'paymentSystems::'], function () {
        Route::get('/', 'PaymentSystemController@index')->name('index');
        Route::get('/{card_transaction}/active', 'PaymentSystemController@updateActive')->name('active');
        Route::get('/{card_transaction}/top', 'PaymentSystemController@updateTop')->name('top');
        Route::patch('/', 'PaymentSystemController@update')->name('update')->middleware('adminOnly');
    });

    Route::group(['prefix' => 'faq', 'as' => 'faq.'], function () {
        Route::get('/', 'FaqController@index')->name('index');
        Route::get('create', 'FaqController@create')->name('create');
        Route::post('/', 'FaqController@store')->name('store');
        Route::get('edit/{faq}', 'FaqController@edit')->name('edit');
        Route::patch('edit/{faq}', 'FaqController@update')->name('update');
        Route::delete('{faq}/delete', 'FaqController@destroy')->name('destroy');
    });


});
Route::group([
    'middleware' => [
        'auth',
        'adminOnly',
    ],
], function () {

    Route::group(['prefix' => 'chart'], function () {
        Route::get('tasks', 'ChartController@drawUsersTasksChart')->name('chart.tasks');
        Route::get('register', 'ChartController@drawRegisterChart')->name('chart.register');
        Route::get('awards', 'ChartController@drawAwardsChart')->name('chart.awards');
        Route::get('earned', 'ChartController@drawTotalEarnedMoney')->name('chart.earned');
        Route::get('transactions', 'ChartController@drawTransactionsChart')->name('chart.transactions');
        Route::get('transactions_amount', 'ChartController@drawTransactionsAmountChart')
            ->name('chart.transactions_amount');
        Route::get('locations', 'ChartController@drawLocationsChart')->name('chart.locations');
        Route::get('locations_pie', 'ChartController@drawLocationsPieChart')->name('chart.locations_pie');
    });

    Route::group(['prefix' => 'stats', 'as' => 'stats::'], function () {
        Route::get('/', 'StatisticsController@index')->name('index');
        Route::get('data', 'StatisticsController@getData')->name('data');
        Route::post('promocodes/add', 'StatisticsController@addPromocode')->name('add_promocode');
        Route::get('users', 'StatisticsController@getUsersStat')->name('getUsers');

    });

    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
        Route::get('create', 'ArticleController@create')->name('create');
        Route::post('store', 'ArticleController@store')->name('store');
        Route::get('edit/{article}', 'ArticleController@edit')->name('edit');
        Route::post('edit/{article}', 'ArticleController@update')->name('update');
        Route::delete('delete/{article}', 'ArticleController@destroy')->name('destroy');
        Route::get('upload', 'ArticleController@images')->name('image');
        Route::post('upload', 'ArticleController@uploadImage')->name('post.image');
        Route::delete('image/{id}', 'ArticleController@deleteImage')->name('delete.image');
    });

});
Route::group([
    'middleware' => [
        'auth',
        'isBanned',
        'admins'
    ],
], function () {
    Route::group(['prefix' => '{service_type}', 'as' => 'service::'], function () {
        Route::get('/', 'ServiceRequestsController@index')->name('index');
        Route::get('{service_request}', 'ServiceRequestsController@show')->name('show');
        Route::post('store', 'ServiceRequestsController@store')->name('store');
        Route::delete('{service_request}', 'ServiceRequestsController@destroy')
            ->name('destroy')->middleware('adminOnly');
    });
});
