<?php

namespace App\Models;

use App\Contracts\Services\CurrencyServiceInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AppPrice
 *
 * @property int $id
 * @property float $android_daily_price_first_user
 * @property float $android_daily_price_second_user
 * @property float $android_daily_price_third_user
 * @property float $android_daily_price_fourth_user
 * @property float $android_daily_price_first_manager
 * @property float $android_daily_price_second_manager
 * @property float $android_daily_price_third_manager
 * @property float $android_daily_price_fourth_manager
 * @property float $ios_daily_price_first_user
 * @property float $ios_daily_price_second_user
 * @property float $ios_daily_price_third_user
 * @property float $ios_daily_price_fourth_user
 * @property float $ios_daily_price_first_manager
 * @property float $ios_daily_price_second_manager
 * @property float $ios_daily_price_third_manager
 * @property float $ios_daily_price_fourth_manager
 * @property float $android_48h_price_first_user
 * @property float $android_48h_price_second_user
 * @property float $android_48h_price_third_user
 * @property float $android_48h_price_fourth_user
 * @property float $android_48h_price_first_manager
 * @property float $android_48h_price_second_manager
 * @property float $android_48h_price_third_manager
 * @property float $android_48h_price_fourth_manager
 * @property float $ios_48h_price_first_user
 * @property float $ios_48h_price_second_user
 * @property float $ios_48h_price_third_user
 * @property float $ios_48h_price_fourth_user
 * @property float $ios_48h_price_first_manager
 * @property float $ios_48h_price_second_manager
 * @property float $ios_48h_price_third_manager
 * @property float $ios_48h_price_fourth_manager
 * @property float $android_72h_price_first_user
 * @property float $android_72h_price_second_user
 * @property float $android_72h_price_third_user
 * @property float $android_72h_price_fourth_user
 * @property float $android_72h_price_first_manager
 * @property float $android_72h_price_second_manager
 * @property float $android_72h_price_third_manager
 * @property float $android_72h_price_fourth_manager
 * @property float $ios_72h_price_first_user
 * @property float $ios_72h_price_second_user
 * @property float $ios_72h_price_third_user
 * @property float $ios_72h_price_fourth_user
 * @property float $ios_72h_price_first_manager
 * @property float $ios_72h_price_second_manager
 * @property float $ios_72h_price_third_manager
 * @property float $ios_72h_price_fourth_manager
 * @property float $other_price
 * @property float $other_price_keywords
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceFirstManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceFirstUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceFourthManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceFourthUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceSecondManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceSecondUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceThirdManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid48hPriceThirdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceFirstManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceFirstUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceFourthManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceFourthUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceSecondManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceSecondUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceThirdManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroid72hPriceThirdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceFirstManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceFirstUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceFourthManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceFourthUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceSecondManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceSecondUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceThirdManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereAndroidDailyPriceThirdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceFirstManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceFirstUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceFourthManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceFourthUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceSecondManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceSecondUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceThirdManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos48hPriceThirdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceFirstManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceFirstUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceFourthManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceFourthUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceSecondManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceSecondUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceThirdManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIos72hPriceThirdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceFirstManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceFirstUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceFourthManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceFourthUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceSecondManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceSecondUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceThirdManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereIosDailyPriceThirdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereOtherPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereOtherPriceKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppPrice extends Model
{

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'android_24h_price_first_user' => 'float',
        'android_24h_price_second_user' => 'float',
        'android_24h_price_third_user' => 'float',
        'android_24h_price_fourth_user' => 'float',
        'android_24h_price_first_manager' => 'float',
        'android_24h_price_second_manager' => 'float',
        'android_24h_price_third_manager' => 'float',
        'android_24h_price_fourth_manager' => 'float',
        'ios_24h_price_first_user' => 'float',
        'ios_24h_price_second_user' => 'float',
        'ios_24h_price_third_user' => 'float',
        'ios_24h_price_fourth_user' => 'float',
        'ios_24h_price_first_manager' => 'float',
        'ios_24h_price_second_manager' => 'float',
        'ios_24h_price_third_manager' => 'float',
        'ios_24h_price_fourth_manager' => 'float',

        'android_48h_price_first_user' => 'float',
        'android_48h_price_second_user' => 'float',
        'android_48h_price_third_user' => 'float',
        'android_48h_price_fourth_user' => 'float',
        'android_48h_price_first_manager' => 'float',
        'android_48h_price_second_manager' => 'float',
        'android_48h_price_third_manager' => 'float',
        'android_48h_price_fourth_manager' => 'float',
        'ios_48h_price_first_user' => 'float',
        'ios_48h_price_second_user' => 'float',
        'ios_48h_price_third_user' => 'float',
        'ios_48h_price_fourth_user' => 'float',
        'ios_48h_price_first_manager' => 'float',
        'ios_48h_price_second_manager' => 'float',
        'ios_48h_price_third_manager' => 'float',
        'ios_48h_price_fourth_manager' => 'float',

        'android_72h_price_first_user' => 'float',
        'android_72h_price_second_user' => 'float',
        'android_72h_price_third_user' => 'float',
        'android_72h_price_fourth_user' => 'float',
        'android_72h_price_first_manager' => 'float',
        'android_72h_price_second_manager' => 'float',
        'android_72h_price_third_manager' => 'float',
        'android_72h_price_fourth_manager' => 'float',
        'ios_72h_price_first_user' => 'float',
        'ios_72h_price_second_user' => 'float',
        'ios_72h_price_third_user' => 'float',
        'ios_72h_price_fourth_user' => 'float',
        'ios_72h_price_first_manager' => 'float',
        'ios_72h_price_second_manager' => 'float',
        'ios_72h_price_third_manager' => 'float',
        'ios_72h_price_fourth_manager' => 'float',

        'other_price' => 'float',
        'other_price_keywords' => 'float',


        'android_30s_price_user' => 'float',
        'android_60s_price_user' => 'float',
        'android_120s_price_user' => 'float',
        'android_300s_price_user' => 'float',
        'android_30s_price_manager' => 'float',
        'android_60s_price_manager' => 'float',
        'android_120s_price_manager' => 'float',
        'android_300s_price_manager' => 'float',

        'android_install_price_user' => 'float',
        'android_install_price_manager' => 'float',
    ];

    public function getAttribute($property)
    {
        if ($property === 'id') {
            parent::getAttribute($property);
        }

        return app(CurrencyServiceInterface::class)->convertFromRub($this->attributes[$property]);
    }

    public function setAttribute($property, $value): void
    {
        $this->attributes[$property] = app(CurrencyServiceInterface::class)->convertToRub($value);
    }

    /**
     * @param array $attributes
     * @return AppPrice|Model|null
     */
    public static function getPrices(array $attributes = ['*']): ?self
    {
        return self::query()->first($attributes);
    }
}
