<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $table = 'referrals';
    protected $guarded = ['id'];

    protected $hidden = ['percent'];
}
