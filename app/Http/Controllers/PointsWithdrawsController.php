<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\points_withdraw;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Http\Requests\UserRequest;
use App\Jobs\SendCustomNotification;
use App\Jobs\SendCustomNotificationToDevice;
use App\Jobs\SendTaskUserNotification;
use App\Models\Award;
use App\Models\Role;
use App\Models\Settings;
use App\Models\Task;
use App\Models\Transaction;
 use App\Models\UserBalanceReplenishment;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
 use Illuminate\View\View;

/**
 * Class BalanceController
 *
 * @package App\Http\Controllers\Api\V1
 */
class PointsWithdrawsController extends BaseController
{
    public function __construct(CurrencyServiceInterface $currencyService)
    {
        parent::__construct($currencyService);
        $this->middleware('editor');
    }
    /**
     *
     * @var \App\Models\User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
 
    /**
     * ProfileController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
   




    public function index():view {

        $title = "Withdraw";
        // $users = User::query()->count();
        $rows  = points_withdraw::where(['status'=>'new'])->get();
        $setting = Settings::first();
        $uc_rate = $setting->uc_rate;
        $popularity_rate = $setting->popularity_rate;
 

        // return view('users.index', compact('title', 'users', 'roles'));

        return view('withdraw.index', compact('title','rows','uc_rate','popularity_rate'));

 
    }




    public function history():view {

        $title = "history";
        // $users = User::query()->count();
         $rows  = points_withdraw::where(['status'=>'done'])->get();
        $setting = Settings::first();
        $uc_rate = $setting->uc_rate;
        $popularity_rate = $setting->popularity_rate;
 

        // return view('users.index', compact('title', 'users', 'roles'));

        return view('withdraw.history', compact('title','rows','uc_rate','popularity_rate'));

 
    }


    public function getRequests(){

        $rows  = points_withdraw::where(['status'=>'new'])->get();

        return response()->json(compact( 'rows'));

    }



public function subStractPoints($req_id){

$request = points_withdraw::find($req_id);
 
if(!$request||$request->status!=='new'||!$request->user){
         Flash::error(trans('messages.access_denied'));

        return redirect('withdraw');
}
 
if($request->user->balance<$request->amount){
        Flash::error('not enought balance');

        return redirect('withdraw');
}



$request->user->balance = $request->user->balance - $request->amount;
$request->user->paid = $request->user->paid + $request->amount;
$request->status="done";

$request->user->save();
$request->save();


  Flash::success("you accept the users withdraw");
  return redirect('withdraw');

    }

  
}
