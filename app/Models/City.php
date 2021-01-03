<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $id_region
 * @property int $country_id
 * @property int $oid
 * @property string $city_name_ru
 * @property string $city_name_en
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $apps
 * @property-read \App\Models\Country $country
 * @property-read string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCityNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCityNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereIdRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereOid($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    const GOOGLE_MAPS_URL = 'https://maps.googleapis.com/maps/api/geocode/json?';

    protected $table = 'cities';

    protected $appends = [
        'name',
    ];

    protected $hidden = [
        'id_region',
        'oid',
        'city_name_en',
        'city_name_ru',
    ];

    /**
     * @param string $cityString
     * @param        $lat
     * @param        $lng
     * @return array
     */
    public static function getCityAndCountry($cityString, $lat, $lng)
    {
        $city = null;
        $country = null;
        if ($cityString !== null && $cityString !== 'null') {
            try {
                $city = City::query()->where('city_name_ru', '=', $cityString)
                    ->orWhere('city_name_en', '=', $cityString)
                    ->firstOrFail();
                $country = $city->country;
            } catch (\Exception $exception) {
                if (($city = self::getCityFromGoogleMaps($lat, $lng)) !== null) {
                    $country = $city->country;
                } else {
                    $cityAndCountryArray = self::getCityAndCountryFromIp();
                    $city = $cityAndCountryArray['city'];
                    $country = $cityAndCountryArray['country'];
                }
            }
        } else {
            $cityAndCountryArray = self::getCityAndCountryFromIp();
            $city = $cityAndCountryArray['city'];
            $country = $cityAndCountryArray['country'];
        }

        return [
            'city' => $city,
            'country' => $country,
        ];
    }

    public static function getCityAndCountryFromIp()
    {
        $city = null;
        $country = null;
        try {
            $geoLoc = \GeoIP::getLocation(\Request::ip());
            $city = City::query()->where('city_name_ru', '=', $geoLoc['city'])
                ->orWhere('city_name_en', '=', $geoLoc['city'])
                ->firstOrFail();
            $country = Country::query()->where('country_name_ru', '=', $geoLoc['country'])
                ->orWhere('country_name_en', '=', $geoLoc['country'])
                ->firstOrFail();
        } catch (\Exception $exception) {
            $city = City::query()->where('city_name_en', '=', 'Moscow')->firstOrFail();
            $country = $city->country;
        }

        return [
            'city' => $city,
            'country' => $country,
        ];
    }

    /**
     * @param $lat
     * @param $lng
     * @return City
     */
    public static function getCityFromGoogleMaps($lat, $lng)
    {
        $latlng = $lat . ',' . $lng;
        $city = null;
        if ($lat && $lng) {
            $cityInfo = json_decode(
                file_get_contents(
                    self::GOOGLE_MAPS_URL .
                    "latlng=$latlng&key=" . env('GOOGLE_MAPS_API_KEY') .
                    '&language=ru'
                )
            );
            $cityInfo = (array) $cityInfo;
            if ($cityInfo['status'] === 'OVER_QUERY_LIMIT') {
                return null;
            }

            $cities = collect();
            foreach ((array) $cityInfo['results'] as $city) {
                foreach ((array) $city->address_components as $name) {
                    if (in_array('locality', $name->types, true)) {
                        $cities->push($name->long_name);
                    }
                }
            }
            $cities = $cities->unique();

            $city = City::query()->whereIn('city_name_ru', $cities->toArray())
                ->orWhereIn('city_name_en', $cities->toArray())
                ->first();
        }

        return $city;
    }

    /**
     * City belongs to country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Builder
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * City can have many apps
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Builder
     */
    public function apps()
    {
        return $this->hasMany(Task::class);
    }

    public function getNameAttribute(): string
    {
        $loc = App::getLocale();

        return $loc === 'ru' ? $this->city_name_ru : $this->city_name_en;
    }
}
