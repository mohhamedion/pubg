<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserIdentifierAttributeTrait;

class UserTask extends Model
{
    use UserIdentifierAttributeTrait;

    const RATING_NOT_AVAILABLE = 0;
    const RATING_AVAILABLE = 1;
    const RATING_ON_MODERATING = 2;
    const RATING_DONE = 3;

    const TASK_ACTIVE = 0;
    const TASK_DONE = 1;
    const TASK_FAILED = 2;
    const TASK_STATUS_AVAILABLE = true;
    const TASK_STATUS_NOT_AVAILABLE = false;
    const BONUS_TASK_AFTER_TIMES = 3; // Allow user to do bonus task (screenshot review) after N application runs.

    protected $table = 'user_tasks';

    protected $guarded = [];

    protected $primaryKey = 'ud';

    protected $appends = [
        'status_for_view',
        'user_identifier',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(TaskReview::class);
    }

    public function scopeSearchByUserIdentifier($query, $value)
    {
        return $query->whereHas('user', function ($query) use ($value) {
            /** @var Builder $query */
            return $query->where('email', 'like', '%' . $value . '%')
                ->orWhere('device_token', 'like', '%' . $value . '%')
                ->orWhere('login', 'like', '%' . $value . '%')
                ->orwhere('name', 'like', '%' . $value . '%');
        });
    }

    public function scopeSearchApp($query, $value)
    {
        return $query->searchByUserIdentifier($value);
    }

    public function scopeSearch($query, $value)
    {
        return $query->searchByUserIdentifier($value);
    }

    public function scopeSort($query, $column, $order)
    {
        if ($column !== 'status_for_view') {
            $query = $query->orderBy($column, $order);
        } else {
            $query->orderBy('status', $order);
        }

        return $query;
    }
    public static function getStatusForView($status)
    {
        $class = null;
        $label = null;
        switch ($status) {
            case self::TASK_ACTIVE:
                $class = 'primary';
                $label = trans('labels.tasks.active');
                break;
            case self::TASK_DONE:
                $class = 'success';
                $label = trans('labels.tasks.done');
                break;
            case self::TASK_FAILED:
                $class = 'danger';
                $label = trans('labels.tasks.failed');
                break;
        }

        return [
            'class' => $class,
            'label' => $label,
        ];
    }

    public function getStatusForViewAttribute()
    {
        return self::getStatusForView($this->getAttribute('status'));
    }
}
