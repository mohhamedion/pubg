<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
  



    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
