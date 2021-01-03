<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralAward extends Model
{
    protected $table = 'referral_awards';
    protected $guarded = ['id'];
    protected $hidden = [
        'referrer_id',
        'referral_id',
        'created_at',
        'updated_at'
    ];

    public function getPaidAttribute($value)
    {
        return (float)number_format($value, 2, '.', '');
    }
}
