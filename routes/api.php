<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//TODO: All old routes to be replace.

//Route::group(['namespace' => 'api\v1'], function (){
//
//    Route::post('/auth', 'ApiController@getToken');
//    Route::get('/users/countries/get', 'ApiController@getCountries');
//    Route::get('/delete', 'ApiController@delete');
//    Route::get('/ip/get', 'GetIPController@get');
//    Route::get('/users/referral', 'UserController@activateCode');
//    Route::get('/users/version', 'UserController@newVersionCheckpoint');
//
//    Route::group(['middleware' => 'token'], function (){
//
//        Route::post('/users/update', 'UserController@updateInformation');
//        Route::post('/users/info', 'UserController@getInformation');
//        Route::post('/users/balance', 'UserController@getBalance');
//        Route::get('/users/referral/info', 'UserController@referralInfo');
//        Route::get('/users/referral/get', 'UserController@getReferral');
//        Route::get('/users/referral/bonus', 'UserController@getReferralProgressBar');
//        Route::get('/users/referral/bonus/get', 'UserController@getReferralBonus');
//        Route::get('/users/level/get', 'UserLevelController@getLevel');
//        Route::get('/users/countries/set', 'UserController@setCountry');
//        Route::get('/users/transactions/history', 'UserController@getHistoryTransaction');
//        Route::get('/users/fcm', 'UserController@updateFcmToken');
//
//        Route::get('/tasks/top', 'TaskController@tasksTop');
//        Route::get('/tasks/new', 'TaskController@newTasks');
//        Route::get('/tasks/get', 'TaskController@getTasks');
//        Route::get('/tasks/check', 'TaskController@checkedTask');
//        Route::get('/tasks/install', 'TaskController@installedTask');
//        Route::get('/tasks/update', 'TaskController@updateTask');
//        Route::get('/tasks/history', 'TaskController@history');
//
//        Route::get('/tasks/event', 'MarathonController@event');
//        Route::get('/tasks/event/checkpoint', 'MarathonController@checkpoint');
//
//
//
//        Route::get('/cards/get', 'UserBonusCardController@getBonusCards');
//
//        Route::get('/videos/get', 'VideoController@getVideos');
//        Route::get('/videos/update', 'VideoController@updateVideo');
//
//
//        Route::get('/partners/update', 'PartnerController@updatePartner');
//
//        Route::get('/cards/transactions/get', 'CardTransactionController@getCardsTransaction');
//        Route::get('/cards/transactions/user/get', 'CardTransactionController@getUsersCardTransaction');
//        Route::get('/cards/transactions/user/buy', 'CardTransactionController@buyCardTransaction');
//        Route::get('/cards/transactions/user/use', 'CardTransactionController@useCardTransaction');
//        Route::get('/cards/transactions/bonus', 'CardTransactionController@getProgressBar');
//
//        Route::get('/quizzes/get', 'QuizController@getQuizzes');
//        Route::get('/quizzes/questions/get', 'QuizController@getQuestions');
//        Route::get('/quizzes/update', 'QuizController@updateQuiz');
//
//        Route::get('/games/get', 'GameController@getGames');
//        Route::get('/games/update', 'GameController@updateGame');
//
//        Route::get('/links/award', 'TaskController@getLinkAward');
//    });
//});

Route::group([
    'namespace' => 'Api\\V1',
    'prefix'    => 'v1',
], function () {
    Route::group([
        'middleware' => 'token',
        //'middleware' => 'admins',
    ], function () {
        Route::get('profile', 'ProfileController@show');

        Route::post('profile', 'ProfileController@update');

        Route::group(['prefix' => 'balance'], function () {
            Route::get('/', 'BalanceController@balance');
            Route::get('details', 'BalanceController@details');
            Route::get('referral', 'BalanceController@referral');
            Route::get('methods','BalanceController@cards');
            Route::get('inventory','BalanceController@userCards');
            Route::post('buy','BalanceController@buyCard');
            Route::post('use','BalanceController@useCard');
        });
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('new', 'TaskController@fresh');
            Route::get('active', 'TaskController@active');
            Route::get('marathon', 'SafeController@current');

            Route::post('marathon', 'SafeController@update');
        });
        Route::group(['prefix' => 'safe'], function () {
            Route::get('progress', 'SafeController@progress');
            Route::get('checkpoint', 'SafeController@checkpoint');
        });
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('top', 'TaskController@tasksTop');
            Route::get('new', 'TaskController@newTasks');
            Route::get('get', 'TaskController@getTasks');
            Route::get('check', 'TaskController@checkedTask');
            Route::get('install', 'TaskController@installedTask');
            Route::get('update', 'TaskController@updateTask');
            Route::get('history', 'TaskController@history');

            Route::post('review', 'TaskReviewController@sendScreen');
        });

        Route::group(['prefix' => 'partners'],function (){
            Route::post('/selectPartner','PartnerController@selectParther');
            Route::get('/list','PartnerController@getPartnersList');
            Route::get('/','PartnerController@getPartners');
        });

        Route::group(['prefix' => 'videos'],function (){
            Route::get('/','VideoController@getVideos');
            Route::get('update', 'VideoController@updateVideo');
        });


        

        Route::group(['prefix' => 'withdrawal'],function (){
                        Route::post('/','PointsWithdrawsController@store');
                         
                    });



        Route::get('/quizzes/get', 'QuizController@getQuizzes');
        Route::get('/quizzes/questions/get', 'QuizController@getQuestions');
        Route::get('/quizzes/update', 'QuizController@updateQuiz');

        Route::get('/games/get', 'GameController@getGames');
        Route::get('/games/update', 'GameController@updateGame');

 



    });
    Route::group(['prefix' => 'fyber'], function () {
        Route::get('reward', 'FyberCallbackController@endpoint');
    });

    Route::group(['prefix' => 'offertoro'], function () {
        Route::get('reward', 'OfferToroCallbackController@endpoint');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('login', 'UserController@login');
        Route::get('countries', 'UserController@countriesList');
        Route::get('fcm', 'UserController@updateFcmToken');


        Route::get('code-activate', 'UserController@activateCode');
    });

  


});


