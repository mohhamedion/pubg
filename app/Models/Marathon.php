<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marathon extends Model
{
    protected $table = 'marathons';
    protected $guarded = [];

    /*protected $appends = ['is_available'];

    protected $casts = [
        'is_available' => 'boolean'
    ];*/

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_marathon', 'marathon_id', 'user_id');
    }

    public function getIsAvailableAttribute()
    {
        return $this->attributes['current_day'] <= 3;
    }

    public function getIsActiveAttribute($value)
    {
        if ($value){

            return $this->attributes['current_day'] <= $this->attributes['all_days'];
        }

        return $value;
    }

    public function getAwardAttribute($value)
    {
        $awards = unserialize($value);

        return $awards;
    }
}
