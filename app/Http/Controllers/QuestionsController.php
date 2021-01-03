<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
 
use App\Http\Requests\UserRequest;

use App\Models\QuizQuestion;
use App\Models\Quiz;

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
class QuestionsController extends BaseController
{
   
    /**
     *
     * @var \App\Models\User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
 
    /**
     * ProfileController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
   




    public function index() {

 
        // return view('users.index', compact('title', 'users', 'roles'));
       $rows = QuizQuestion::all();
       $title='Quizzes';
        return view('questions.index', compact('title','rows'));

 
    }

  public function create() {

 
        // return view('users.index', compact('title', 'users', 'roles'));
       $quizzs = Quiz::all();
       $title='Create';
        return view('questions.create', compact('title','quizzs'));

 
    }

  public function edit($quizz_id) {

 		       $quizzs = Quiz::all();

        // return view('users.index', compact('title', 'users', 'roles'));
       $quizz = QuizQuestion::find($quizz_id);
       $title='edit quizz';
        return view('questions.edit', compact('title','quizz','quizzs'));

 
    }

 public function store(Request $request) {

 

     $validator = Validator::make($request->all(), [ 

                 'question' => 'required', 
                 'A' => 'required', 
                 'B' => 'required', 
                 'C' => 'required', 
                 'D' => 'required', 
                 'correct_question' => 'correct_question', 
       
               
            ]);
            if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], 401);            
            }
             

  		$quizz= new QuizQuestion();
  		$quizz->question= $request->question;
  		$quizz->quiz_id=$request->quiz_id;
  		$quizz->A= $request->A;
  		$quizz->B= $request->B;
  		$quizz->C= $request->C;
      $quizz->D= $request->D;
   		$quizz->correct_answer= $request->correct_answer;
  		$quizz->save();


			 return redirect('questions');
 
    }

 public function update(   $quizz,Request $request ) {
 
  	 $quizz=   QuizQuestion::find($quizz);
 
   $validator = Validator::make($request->all(), [ 

                 'question' => 'required', 
                 'A' => 'required', 
                 'B' => 'required', 
                 'C' => 'required', 
                 'D' => 'required', 
                 'correct_question' => 'correct_question' 
       
               
            ]);
            if ($validator->fails()) { 
                        return response()->json(['error'=>$validator->errors()], 401);            
            }


   		$quizz->question= $request->question;
      $quizz->quiz_id=$request->quiz_id;
  		$quizz->A= $request->A;
  		$quizz->B= $request->B;
  		$quizz->C= $request->C;
  		$quizz->D= $request->D;
  		$quizz->correct_answer= $request->correct_answer;

  	// 	switch ($quizz->correct_answer) {
  	// 			 	case 'A':
			// $quizz->correct_answer= $request->A;
			// 	break;
			// 		case 'B':
			// $quizz->correct_answer= $request->B;
			// 	break;
			// 		case 'D':
			// $quizz->correct_answer= $request->D;
			// 	break;
			// 		case 'C':
			// $quizz->correct_answer= $request->C;
			// 	break;
  	// 		default:
  	// 					$quizz->correct_answer= $request->A;

  	// 			break;
  	// 	}

  		$quizz->save();

             
 
 
return redirect()->route('questions::edit',$quizz->id);
      
 
 
    }
  

            public function delete($quizz) {
             
                 $quizz =   QuizQuestion::find($quizz);
              if( $quizz){
                 $quizz->delete();
              }

            return redirect()->route('questions::index');
                  
                }
              


  
}
