<?php

namespace App\Models;

use App\Traits\AmountAttributeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpecialOffer
 *
 * @property int $id
 * @property string $name
 * @property float $amount
 * @property array $features
 * @property bool $popular
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer wherePopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SpecialOffer extends Model
{

    use AmountAttributeTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'float',
        'features' => 'array',
        'popular' => 'boolean',
    ];

    /**
     * Users who bought special offers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_special_offer_pivot', 'special_offer_id');
    }
}
