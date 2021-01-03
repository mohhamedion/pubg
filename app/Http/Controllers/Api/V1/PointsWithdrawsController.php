<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\points_withdraw;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

/**
 * Class BalanceController
 *
 * @package App\Http\Controllers\Api\V1
 */
class PointsWithdrawsController extends Controller
{

    /**
     *
     * @var \App\Models\User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    private $user = null;

    /**
     * ProfileController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))
            ->first();
    }





    public function store(Request $request){


            $validator = Validator::make($request->all(), [ 
                 'player_id' => 'required|numeric', 
                 'amount' => 'required|numeric|gt:0',
                 "type" => 'required'    
            ]);
            if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], 401);            
            }
             

                $old_request = points_withdraw::where(["user_id"=>$this->user->id,"status"=>"new","type"=>$request->type])->get();
 
                if($old_request->count()>0){
                            return response()->json(['response_code'=>501,'message'=>'you already send a request']);
                                }


                 if($this->user->balance<$request->amount){
                          return response()->json(['response_code'=>500,'message'=>'not enough points']);
                }
 
            $points  = new points_withdraw();

            $points->player_id = $request->player_id;
            $points->status = 'new';
            $points->user_id =  $this->user->id;
            $points->amount = $request->amount;
            $points->type = $request->type;
            $points->save();

            return response()->json(['response_code'=>200]);

    }

  
}
