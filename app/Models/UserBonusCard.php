<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBonusCard extends Model
{
    protected $table = 'user_bonus_cards';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_bonus_cards', 'bonus_card_id', 'user_id');
    }

}
