<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * App\Models\TaskReview
 *
 * @property int $id
 * @property int|null $task_id
 * @property int $user_id
 * @property int $state
 * @property string|null $screenshot
 * @property \Carbon\Carbon|null $reviewed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $screenshot_url
 * @property-read mixed $title
 * @property-read \App\Models\Task|null $task
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview onModeration()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereScreenshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskReview whereUserId($value)
 * @mixin \Eloquent
 */
class TaskReview extends Model
{

    const REVIEW_EMPTY = 0;

    const REVIEW_AVAILABLE = 1;
    const REVIEW_MODERATING = 2;
    const REVIEW_DONE = 3;
    const REVIEW_FAILED = 4;

    const COMMENT_AVAILABLE = 5;
    const COMMENT_MODERATING = 6;
    const COMMENT_DONE = 7;
    const COMMENT_FAILED = 8;

    const REVIEW_SCREENSHOTS_FOLDER = 'public/uploads/reviews';

    protected $guarded = ['id'];

    protected $dates = [
        'reviewed_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'screenshot_url',
        'title',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Builder|Task
     */
    public function task()
    {
        return $this->belongsTo(UserTask::class,'user_task_ud');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Builder|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getScreenshotUrlAttribute(): string
    {
        return url(Storage::url(self::REVIEW_SCREENSHOTS_FOLDER . "/{$this->screenshot}"));
    }

    public function getTitleAttribute(): string
    {
        return $this->state === TaskReview::COMMENT_MODERATING
            ? trans('labels.title_comment')
            : trans('labels.title_review');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnModeration($query)
    {
        return $query->whereIn('state', [TaskReview::REVIEW_MODERATING, TaskReview::COMMENT_MODERATING]);
    }
}
