<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AppReview
 *
 * @property int $id
 * @property int $app_id
 * @property int $rates
 * @property int $comments
 * @property array $keywords
 * @property int $stars
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereRates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppReview whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppReview extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'keywords' => 'array',
    ];

    public function application()
    {
        //return $this->belongsTo(Application::class, 'app_id');
    }
}
