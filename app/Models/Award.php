<?php

namespace App\Models;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Traits\AmountAttributeTrait;
use App\Traits\CurrencyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Award
 *
 * @property int $id
 * @property int|null $referral_system
 * @property float $amount
 * @property int $user_id
 * @property int|null $referral_id
 * @property int|null $application_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Application|null $app
 * @property-read string $amount_formatted
 * @property-read null|string $currency
 * @property-read null|string $referral_system_label
 * @property-read \App\Models\User|null $referral
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award awardsBetweenDate($referral_system, $date_from, $date_to = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award filter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award searchByAppName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award searchByDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award searchByReferralSystem($referral_system)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereReferralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereReferralSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Award whereUserId($value)
 * @mixin \Eloquent
 */
class Award extends Model
{
    use CurrencyTrait;
    use AmountAttributeTrait;

    const AWARD_REFERRAL = 1;
    const AWARD_VIDEO = 3;
    const AWARD_GAME = 4;
    const AWARD_PARTNER = 15;
    const AWARD_BONUS = 16;
    const AWARD_REFILL = 5;
    const OFFER_PERSONALY = 6;
    const OFFER_TRIALPAY = 7;
    const OFFER_ADXMI = 8;
    const OFFER_ADSCEND = 9;
    const OFFER_SUPERSONIC = 10;
    const OFFER_TAPJOY = 11;
    const OFFER_FYBER = 12;

    const OFFERS = [
        Award::OFFER_PERSONALY => 'Persona.ly',
        Award::OFFER_TRIALPAY => 'Trialpay',
        Award::OFFER_ADXMI => 'ADXMI',
        Award::OFFER_ADSCEND => 'Adscend',
        Award::OFFER_SUPERSONIC => 'SuperSonicAds',
        Award::OFFER_TAPJOY => 'TapJoy',
        Award::OFFER_FYBER => 'Fyber',
    ];

    protected $table = 'awards';
    protected $guarded = ['id'];
    protected $appends = [
        'currency',
        'referral_system_label',
        'amount_formatted',
    ];

    /**
     * User which receives award
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Award for referral
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }

    /**
     * Award from some app
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(Task::class, 'application_id');
    }

    /**
     * @return null|string
     */
    public function getReferralSystemLabelAttribute(): ?string
    {
        $label = null;
        switch ($this->referral_system) {
            case null:
                $label = trans('labels.tasks.tasks');
                break;
            case User::REFERRAL_SYSTEM_FIRST:
                $label = trans('labels.referral_first');
                break;
            case User::REFERRAL_SYSTEM_SECOND:
                $label = trans('labels.referral_second');
                break;
            case self::AWARD_VIDEO:
                $label = trans('labels.award_standard_task_video_short');
                break;
            case self::AWARD_GAME:
                $label = trans('labels.award_standard_task_game_short');
                break;
            case self::AWARD_PARTNER:
                $label = trans('labels.award_standard_task_partner_short');
                break;
            case self::AWARD_BONUS:
                $label = trans('labels.award_standard_task_bonus_short');
                break;
            case self::AWARD_REFILL:
                $label = trans('labels.refill');
                break;
            case self::OFFER_PERSONALY:
                $label = self::OFFERS[self::OFFER_PERSONALY];
                break;
            case self::OFFER_TRIALPAY:
                $label = self::OFFERS[self::OFFER_TRIALPAY];
                break;
            case self::OFFER_ADXMI:
                $label = self::OFFERS[self::OFFER_ADXMI];
                break;
            case self::OFFER_ADSCEND:
                $label = self::OFFERS[self::OFFER_ADSCEND];
                break;
            case self::OFFER_SUPERSONIC:
                $label = self::OFFERS[self::OFFER_SUPERSONIC];
                break;
            case self::OFFER_FYBER:
                $label = self::OFFERS[self::OFFER_FYBER];
                break;
        }

        return $label;
    }

    /**
     * Search function
     *
     * @param Builder|self $query
     * @param string $filters
     *
     * @return Builder
     */
    public function scopeFilter($query, $filters)
    {
        $filters = mb_strtolower($filters);
        $filters = json_decode($filters, true);
        /** @var array $filters */
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'referral_system_label':
                    $query = $query->searchByReferralSystem($value);
                    break;
                case 'created_at':
                    $query = $query->searchByDate($value);
                    break;
                case 'app.name':
                    $query = $query->searchByAppName($value);
                    break;
            }
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string $referral_system
     *
     * @return Builder|self
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByReferralSystem($query, $referral_system)
    {
        if ((int) $referral_system === 0) {
            return $query->whereNull('referral_system');
        }

        return $query->where('referral_system', '=', (int) $referral_system);
    }

    /**
     * @param Builder|self $query
     * @param string $value
     *
     * @return Builder|self mixed
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByAppName($query, string $value)
    {
        return $query->whereHas('app', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('name', 'like', '%' . $value . '%');
        })->orWhereHas('app', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('package_name', 'like', '%' . $value . '%');
        });
    }

    /**
     * @param Builder $query
     * @param string $value
     *
     * @return Builder mixed
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByDate($query, $value)
    {
        return $query->whereDate('created_at', '=', $value);
    }

    /**
     * @return string
     */
    public function getAmountFormattedAttribute()
    {
        return $this->getAttribute('amount') . ' ' . app(CurrencyServiceInterface::class)->getCurrency();
    }

    /**
     * @param Builder $query
     * @param int $referral_system
     * @param string|null $date_from
     * @param string|null $date_to
     *
     * @return Builder|self
     */
    public function scopeAwardsBetweenDate($query, int $referral_system, $date_from, $date_to = null)
    {
        /** @var Builder $query */
        $query = $query->whereNotNull('referral_system')
            ->where('referral_system', '=', $referral_system);

        if (!is_null($date_from) && !is_null($date_to)) {
            $query->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to);
        } elseif (!is_null($date_from)) {
            $query->whereDate('created_at', '>=', $date_from);
        } elseif (!is_null($date_to)) {
            $query->whereDate('created_at', '<=', $date_to);
        }

        return $query;
    }
}
