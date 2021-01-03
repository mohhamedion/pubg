<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    protected $table = 'user_quizzes';
    protected $guarded = ['id'];

    protected $casts = [
        'is_available' => 'boolean'
    ];
}
