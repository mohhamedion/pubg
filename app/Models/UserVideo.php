<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserVideo extends Model
{
    const TIME = 24;

    protected $table = 'user_videos';
    protected $guarded = ['id'];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
