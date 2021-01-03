<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TaskReview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
use Storage;

class TaskReviewController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->user = User::whereToken($request->header('token'))->first();
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/tasks/review",
     *     summary="Send task's review",
     *     tags={"tasks"},
     *     operationId="Send task's review",
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
     *         name="task_id",
     *         in="query",
     *         description="id of task",
     *         required=true,
     *         type="integer",
     *
     *     ),
     *     @SWG\Parameter(
     *         name="screen",
     *         in="formData",
     *         description="screen",
     *         required=true,
     *         type="file",
     *
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, api status provided",
     *     ),
     *     @SWG\Response(
     *         response=476,
     *         description="Review already exists",
     *     ),
     * ),
     */
    public function sendScreen(Request $request)
    {
        $user_task = $this->user->tasks()->whereId($request->get('task_id'))->first();
        $done = $this->user->taskReviews()->whereUserTaskUd($user_task->pivot->ud)->exists();

        if ($done) {
            return response()->json(null, 476);
        }

        $file = $request->file('screen');

        $review = TaskReview::query()->create([
            'user_task_ud' =>  $user_task->pivot->ud,
            'user_id' => $this->user->id,
            'state' => TaskReview::COMMENT_AVAILABLE,
        ]);

        $file_name = $file->hashName();

        $file->storeAs(TaskReview::REVIEW_SCREENSHOTS_FOLDER, $file_name);

        if (!empty($review->screenshot)) {
            $path = TaskReview::REVIEW_SCREENSHOTS_FOLDER . '/' . $review->screenshot;
            if (File::exists(storage_path('app/' . $path))) {
                Storage::delete($path);
            }
        }

        switch ($review->state) {
            case TaskReview::REVIEW_AVAILABLE:
                $state = TaskReview::REVIEW_MODERATING;
                break;
            case TaskReview::COMMENT_AVAILABLE:
                $state = TaskReview::COMMENT_MODERATING;
                break;
            default:
                $state = TaskReview::REVIEW_EMPTY;
        }

        $review->update([
            'state' => $state,
            'screenshot' => $file_name,
            'reviewed_at' => Carbon::now(),
        ]);

        $user_task->pivot->is_rating_available = 2;
        $user_task->pivot->save();

        return response()->json(null, 200);
    }
}
