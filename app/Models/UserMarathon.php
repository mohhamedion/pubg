<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMarathon extends Model
{
    protected $table = 'users_marathon';
    protected $guarded = ['id'];
}
