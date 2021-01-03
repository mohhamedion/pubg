<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Models\User;

class points_withdraw extends Model
{
      use Notifiable;


 protected $fillable = [
        'player_id',
        'status',
        'user_id',
        'type',
        'amount'
    ];


   public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
