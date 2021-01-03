<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVideoLimit extends Model
{
    protected $table = 'user_video_limits';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
