<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentSystem
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentSystem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentSystem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentSystem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentSystem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentSystem extends Model
{

    const IMAGE_FOLDER = '/images/payment-systems'; // in "public" directory

    protected $guarded = [
        'id',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): string
    {
        return url(self::IMAGE_FOLDER . "/{$this->image}");
    }

    const PAYMENT_SYSTEMS = [
        [
            'name' => 'Webmoney',
            'image' => 'webmoney-l1.png',
        ],
        [
            'name' => 'Qiwi',
            'image' => 'qiwi-l4.png',
        ],
        [
            'name' => 'YandexMoney',
            'image' => 'yandex-l2.png',
        ],
        [
            'name' => 'Tele2',
            'image' => 'tele2-l.png',
        ],
        [
            'name' => 'Megafon',
            'image' => 'megafon-l2.png',
        ],
        [
            'name' => 'Beeline',
            'image' => 'beeline-l1.png',
        ],
        [
            'name' => 'Mts',
            'image' => 'MTS-l2.png',
        ],
        [
            'name' => 'Paypal',
            'image' => 'paypal-1.png',
        ],
        [
            'name' => 'WorldOfTanks',
            'image' => 'wot.png',
        ],
        [
            'name' => 'Warface',
            'image' => 'log-warface.png',
        ],
        [
            'name' => 'Steam',
            'image' => 'steam-logo.png',
        ],
        [
            'name' => 'VK',
            'image' => 'vk-logo.png',
        ],
    ];
}
