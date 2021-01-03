<?php

namespace App\Models;

use App\Contracts\Services\CurrencyServiceInterface;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $guarded = ['id'];
    protected $casts = [
        'exchange_rate_rub_uah' => 'float',
        'withdraw_limit' => 'float',
        'transfer_commission' => 'float',
        'referral_first_balance_limit' => 'float',
        'referral_second_balance_limit' => 'float',
        'award_standard_task_video' => 'float',
        'award_standard_task_vk_group' => 'float',
        'referral_first_reward_percentage' => 'integer',
        'referral_second_reward_percentage' => 'integer',
        'referral_second_reward_time' => 'integer',
        'application_downloads_min_limit' => 'integer',
        'balance_replenishment_min' => 'float',
        'review_price' => 'float',
        'review_comment_price' => 'float',
        'review_keywords' => 'array',
        'description_price' => 'float',
        'award_register_with_promo' => 'float',
        'click_price' => 'float',
        'cashback' => 'json'
    ];

    protected $appends = ['currency'];

    public function getRateAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getAwardStandardPromoCodeAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getAwardPartnerPromoCodeAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getWithdrawLimitAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setWithdrawLimitAttribute($price): void
    {
        $this->attributes['withdraw_limit'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }

    public function getReferralFirstBalanceLimitAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

/*    public function setReferralFirstBalanceLimitAttribute($price): void
    {
        $this->attributes['referral_first_balance_limit'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }*/

    public function getReferralSecondBalanceLimitAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

/*    public function setReferralSecondBalanceLimitAttribute($price): void
    {
        $this->attributes['referral_second_balance_limit'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }*/

    public function getAwardStandardTaskVideoAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    /*public function setAwardStandardTaskVideoAttribute($price): void
    {
        $this->attributes['award_standard_task_video'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }*/

    public function getAwardStandardTaskVkGroupAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

 /*   public function setAwardStandardTaskVkGroupAttribute($price): void
    {
        $this->attributes['award_standard_task_vk_group'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }*/

    public function getBalanceReplenishmentMinAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setBalanceReplenishmentMinAttribute($price): void
    {
        $this->attributes['balance_replenishment_min'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }

    public function getReviewPriceAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setReviewPriceAttribute($price): void
    {
        $this->attributes['review_price'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }

    public function getReviewCommentPriceAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setReviewCommentPriceAttribute($price): void
    {
        $this->attributes['review_comment_price'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }

    public function getDescriptionPriceAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function getTopPriceAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setDescriptionPriceAttribute($price): void
    {
        $this->attributes['description_price'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }

    /*public function getClickPriceAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }*/

    /*public function setClickPriceAttribute($price): void
    {
        $this->attributes['click_price'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }*/

    public function getCurrencyAttribute()
    {
        return "руб";
    }

    /**
     * @param array $attributes
     *
     * @return Settings|Model|null
     */
    public static function getInstance(array $attributes = ['*'])
    {
        return self::query()->first($attributes);
    }

    /**
     * @param string $key
     * return cashback %
     * @return int
     */
    public function getCashback(string $key = null): int
    {
        return isset($this->cashback[$key])
            ? intval($this->cashback[$key])
            : 0;
    }

    /**
     * @param $amount
     * @return float|int
     */
    public function calcCashback($amount)
    {
        switch ($amount) {
            case $amount >= 5000 && $amount < 29999:
                return $amount * $this->getCashback('first') / 100;
            case $amount >= 30000 && $amount < 69999:
                return $amount * $this->getCashback('second') / 100;
            case $amount >= 70000 && $amount < 149999:
                return $amount * $this->getCashback('third') / 100;
            case $amount >= 150000 && $amount < 299999:
                return $amount * $this->getCashback('fourth') / 100;
            case $amount >= 300000 && $amount < 499999:
                return $amount * $this->getCashback('fifth') / 100;
            case $amount >= 500000:
                return $amount * $this->getCashback('sixth') / 100;
            default:
                return 0;
        }
    }
}
