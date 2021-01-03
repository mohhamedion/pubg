<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardTransaction extends Model
{
    protected $table = 'card_transactions';
    protected $guarded = [];

    const IMAGE_FOLDER = '/images/payment-systems'; // in "public" directory

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): string
    {
        return url(self::IMAGE_FOLDER . "/{$this->image}");
    }
}
