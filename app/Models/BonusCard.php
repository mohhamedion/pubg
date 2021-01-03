<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusCard extends Model
{
    const AMOUNT = 5;

    protected $table = 'bonus_cards';
    protected $guarded = ['id'];

    public function getBonusAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function cardsForUser(User $user)
    {
        $count = BonusCard::all()->count();
        $user_cards = [];

        for($i = 0; $i < self::AMOUNT; $i++){
            $user_cards[] = BonusCard::find(rand(0, $count))->first();
            $user->bonusCards()->attach($user_cards[$i]->id);
        }

        return $user_cards;
    }
}
