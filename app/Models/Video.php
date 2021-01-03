<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    const TIME = 24;

    const IMAGE_FOLDER = '/images/videos'; // in "public" directory

    protected $table = 'videos';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_videos', 'video_id', 'user_id');
    }

    public function getAwardAttribute($value)
    {
        return (float)number_format($value, 2, '.', '');
    }

    public function getImageUrlAttribute(): string
    {
        return url(self::IMAGE_FOLDER . "/{$this->attributes['image_url']}");
    }
}
