<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $guarded = [];
    protected $hidden = ['image'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return is_null($this->attributes['image']) ? null : config('app.url') . Storage::url($this->image);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
