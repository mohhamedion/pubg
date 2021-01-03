<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateAward extends Model
{
    protected $table = 'rate_awards';
    protected $guarded = ['id'];

    public function getTaskAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getVideoAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getPartnerAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getReferralAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }
}
