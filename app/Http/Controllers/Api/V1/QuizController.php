<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Settings;
use App\Models\User;
use App\Traits\UserQuizTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use UserQuizTrait;

    protected $user;

    private static $hidden_quiz_attributes = [
        'offset',
        'created_at',
        'updated_at',
    ];

    private static $hidden_quiz_pivot_attributes = [
        'user_id',
        'quiz_id',
        'last_open',
        'created_at',
        'updated_at',
    ];

    private static $hidden_quiz_question_attributes = [
        'quiz_id',
        'created_at',
        'updated_at',
    ];


    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
        if ($this->user) {
            $this->initQuizzes($this->user);
        }
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/quizzes/get",
     *     summary="Get quizzes",
     *     tags={"quizzes"},
     *     operationId="Get quizzes",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Quiz")
     *         )
     *  ),
     * ),
     */
    public function getQuizzes()
    {
        $quizzes = Quiz::all();
        $empty = [];
        foreach ($quizzes as $key => $item) {
            if (count($item->questions) == 0) {
                array_push($empty, $key);
            }
        }
        $user_quizzes = $this->user->quizzes()->get();
        $quizIds = $user_quizzes->pluck('id');

        foreach ($quizzes as $quiz) {
            $first = array_first($quizIds, function ($value) use ($quiz) {
                return $value == $quiz->id;
            });
            if ($first) {
                continue;
            } else {
                $this->user->quizzes()->attach($quiz->id);
                $quiz = $this->user->quizzes()->where('id','=',$quiz->id)->get()->map(function ($quiz) {
                    $quiz->pivot->last_open = Carbon::now()->toDateString();
                    $quiz->pivot->save();

                    return $quiz;
                });
            }
        }

        $quizzes = $this->user->quizzes()
            ->get()
            ->map(function ($quiz) {
                $quiz->makeHidden(self::$hidden_quiz_attributes);
                $quiz->pivot->makeHidden(self::$hidden_quiz_pivot_attributes);

                $quiz->pivot->is_available = (bool)$quiz->pivot->is_available;
                $quiz->pivot->earned = (float)number_format($quiz->pivot->earned, 2, '.', '');

                return $quiz;
            });
        foreach ($empty as $item) {
            $quizzes->pull($item);
        }
        return response()->json($quizzes, 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/quizzes/questions/get",
     *     summary="Get quiz questions",
     *     tags={"quizzes"},
     *     operationId="Get quiz questions",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of quiz",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *         @SWG\Schema(ref="#/definitions/Questions")
     *  ),
     *     @SWG\Response(
     *         response=435,
     *         description="This quiz isn't available now",
     *  ),
     * ),
     */
    public function getQuestions(Request $request)
    {
        $quiz = $this->user->quizzes()->find($request->get('id'));

        if ($quiz->pivot->is_available == 0) {
            return response()->json(null, 435);
        }

        /*$count_all = QuizQuestion::all()->count();
        $count = $quiz->questions()->count();
        $array = range(0, $count_all);
        $array = array_slice($array, $quiz->offset, $count);
        shuffle($array);
        $array = array_slice($array, 0, 10);
        $questions = [];

        for($i = 0; $i < 10; $i++) {
            $questions[] = QuizQuestion::find($array[$i])->makeHidden(self::$hidden_quiz_question_attributes);
        }*/


        /* $count_questions = $quiz->questions()->count();
        $questions = $quiz->questions()
            ->take($count_questions)
            ->get()->toArray();
        shuffle($questions);
        $questions = array_slice($questions, 0, 10);
 */

        $questions = $quiz->questions()
                            ->take(10)
                            ->inRandomOrder()
                            ->get()
                            ->toArray();

       /* for($i = 0; $i < 10; $i++) {
            $questions[$i]->makeHidden(self::$hidden_quiz_question_attributes);
        }*/

        return response()->json([
            'quiz_id' => $quiz->id,
            'questions' => $questions,
        ], 200);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/quizzes/update",
     *     summary="Update the quiz",
     *     tags={"quizzes"},
     *     operationId="Update the quiz",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         description="token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="quiz_id of any question",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="score",
     *         in="query",
     *         description="amount of correct answers",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *  ),
     *     @SWG\Response(
     *         response=435,
     *         description="This quiz isn't available now",
     *  ),
     * ),
     */
    public function updateQuiz(Request $request)
    {
        $quiz = $this->user->quizzes()->find($request->get('id'));

        if ($quiz->pivot->is_available == 0) {
            return response()->json(null, 435);
        }

        $quiz->pivot->today_times += 1;
        $quiz->pivot->times += 1;
        $quiz->pivot->earned = (float) number_format($quiz->pivot->earned, 2, '.', '');
        $quiz->pivot->last_open = Carbon::now()->toDateString();

        $rate = Settings::first()->points_rate;
        $ans = 0;
        if ($request->get('score') >= 5 && $request->get('score') != 10) {
            $this->user->balance += 0.05 * $rate;
            $quiz->pivot->earned += 0.05 * $rate;
              $ans = 0.05 * $rate;
        } elseif ($request->get('score') == 10) {
             $ans =  0.1 * $rate;
            $this->user->balance += 0.1 * $rate;
            $quiz->pivot->earned += 0.1 * $rate;
        }

        // $quiz->pivot->save();
        // $this->user->save();

        return response()->json($ans, 200);
    }
}
