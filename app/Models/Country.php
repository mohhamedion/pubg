<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property int $oid
 * @property string $country_name_ru
 * @property string $country_name_en
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $apps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCountryNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCountryNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereOid($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    public const GROUPS = [
        'cis' => [
            'All',
            'Russia',
            'Ukraine',
            'Belarus',
            'Kazakhstan',
            'Kyrgyzstan',
            'Azerbaijan',
            'Armenia',
            'Moldova',
            'Uzbekistan',
            'Tajikistan',
        ],
        'europe' => [
            'All',
            'Germany',
            'United Kingdom',
        ],
        'america' => [
            'All',
            'United States',
            'Canada',
            'Brazil',
        ],
        'asia' => [
            'All',
            'India',
        ],
        'oceania' => [
            'All',
            'Australia',
        ],
    ];

    protected $table = 'countries';

    protected $hidden = [
        'oid',
    ];

    /**
     * Country has many cities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Builder|City
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * country can have many apps
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Builder
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getNameAttribute(): string
    {
        $loc = App::getLocale();

        return $loc === 'ru' ? $this->country_name_ru : $this->country_name_en;
    }
}
