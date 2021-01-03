<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    protected $table = 'user_levels';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTaskAttribute($value)
    {
        return unserialize($value);
    }

    public function getVideoAttribute($value)
    {
        return unserialize($value);
    }

    public function getPartnerAttribute($value)
    {
        return unserialize($value);
    }

    public function getReferralAttribute($value)
    {
        return unserialize($value);
    }

    public function check()
    {
        if ($this->task[0] >= $this->task[1]) {
            $array = $this->task;
            $array[2] += 1;
            $limit = LevelLimit::whereLevel($array[2])->first();
            $array[1] = $limit->task;
            $this->task = serialize($array);
            $this->stars += $array[3];
        }
        if ($this->video[0] >= $this->video[1]) {
            $array = $this->video;
            $array[2] += 1;
            $limit = LevelLimit::whereLevel($array[2])->first();
            $array[1] = $limit->video;
            $this->video = serialize($array);
            $this->stars += $array[3];
        }
        if ($this->partner[0] >= $this->partner[1]) {
            $array = $this->partner;
            $array[2] += 1;
            $limit = LevelLimit::whereLevel($array[2])->first();
            $array[1] = $limit->partner;
            $this->partner = serialize($array);
            $this->stars += $array[3];
        }
        if ($this->referral[0] >= $this->referral[1]) {
            $array = $this->referral;
            $array[2] += 1;
            $limit = LevelLimit::whereLevel($array[2])->first();
            $array[1] = $limit->referral;
            $this->referral = serialize($array);
            $this->stars += $array[3];
        }

        if (((int) round($this->stars / 10)) > $this->level) {
            $this->level = (int) round($this->stars / 10);
            $user = $this->user()->first();
            $user->balance += 100;
            $user->logAward(100, Award::AWARD_BONUS, null);
        }

        $this->save();
    }
}
