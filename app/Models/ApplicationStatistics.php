<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplicationStatistics
 *
 * @property int $id
 * @property int $application_id
 * @property int $limit
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Task $application
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApplicationStatistics whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApplicationStatistics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApplicationStatistics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApplicationStatistics whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApplicationStatistics whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplicationStatistics extends Model
{
    protected $guarded = [
        'id',
    ];

    public function application()
    {
        return $this->belongsTo(Task::class);
    }
}
