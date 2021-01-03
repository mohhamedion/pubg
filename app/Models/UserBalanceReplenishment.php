<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserBalanceReplenishment
 *
 * @property int $id
 * @property int|null $ik_inv_id
 * @property string|null $ik_pm_no
 * @property int|null $unitpayId
 * @property float $amount
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereIkInvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereIkPmNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereUnitpayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceReplenishment whereUserId($value)
 * @mixin \Eloquent
 */
class UserBalanceReplenishment extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }
}
