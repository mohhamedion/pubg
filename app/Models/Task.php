<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Auth;

class Task extends Model
{

    const PROMOTION_BY_COUNTRY = 0; // by country
    const PROMOTION_BY_CITY = 1; // by city
    const PROMOTION_BY_KEYWORDS = 2; // by keywords

    const DEFAULT_DAYS_ATTR = 3;
    const DEFAULT_TIME_DELAY_ATTR = 24;

    const TWENTY_FOUR = 24;
    const FORTY_EIGHT = 48;
    const SEVENTY_TWO = 72;

    protected $table = 'tasks';
    protected $guarded = ['id'];

    protected $appends = [
        'daily_award',
        'price_for_user',
        'amount_for_user',
        'amount',
        'limit_state',
        'total_runs',
        'installs_today',
        'time_delay_formatted',
        'expected_price_for_user',
        'user_task_price',
        'amount_wasted',
        'formatted_created_at',
        'reviews_moderate',
        'rate_keywords',
        'rate_type',
        'install_price',
        'install_price_for_user',
    ];

    protected $casts = [
        'award' => 'float',
        'dailyAward' => 'float',
        'amount' => 'float',
        'amount_for_user' => 'float',
        'price_for_user' => 'float',
        'keywords' => 'array',
    ];

    protected $hidden = [
        'min_tasks_limit_active',
        'min_tasks_limit',
        'user_id',
        'created_by',
        'device_type',
        'deferred_start',
        'custom_price',
        'slug',
        'description_active',
        'tracking_service',
        'promotion_type',
        'limit',
        'daily_budget',
        'daily_budget_amount',
        'daily_budget_installs_limit',
        'country_group',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id')
            ->withPivot('is_accepted', 'is_installed');
    }

    public function tasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function reviewTasks()
    {
        return $this->hasManyThrough(TaskReview::class, UserTask::class);
    }

    public function review()
    {
        return $this->hasOne(AppReview::class, 'app_id');
    }

    public function getAwardAttribute()
    {
        $rate = Settings::first()->rate;
        if ($this->attributes['id'])
            return (float)number_format($this->attributes['price'] * $rate * ($this->attributes['days'] / ($this->attributes['time_delay'] / 24 )), 2, '.', '');
        return 0;
    }

    public function getDailyAwardAttribute()
    {
        if ($this->attributes['id'])
            return (float)number_format($this->award / ($this->attributes['days'] / ($this->attributes['time_delay'] / 24 )), 2, '.', '');
        return 0;
    }

    public function getInstallPriceAttribute($value)
    {
        if ($this->attributes['id'])
            return (float)number_format($value, 2, '.', '');
        return 0;
    }

    public function getTopAttribute($value)
    {
        return (bool)$value;
    }

    public function canBeCancelled(): bool
    {
        if ($this->id) {
            if (auth()->user()->id === $this->user_id
                || $this->created_by === $this->user_id
                || auth()->user()->hasRole('admin')
            ) {
                return $this->moderated && !$this->canceled;
            }

            return false;
        }

        return false;
    }

    public function canBeChanged(): bool
    {
        if (auth()->user()->hasRole('manager')) {
            if ($this->paid && !$this->moderated) {
                return false;
            }

            return true;
        }

        return true;
    }

    public function canBeStared(): array
    {
        $result = true;
        $reason = '';

        if (!$this->paid) {
            $result = false;
            $reason = trans('messages.campaign_not_paid');
        } elseif (!$this->moderated) {
            $result = false;
            $reason = trans('messages.campaign_not_moderated');
        } elseif (!$this->accepted) {
            $result = false;
            $reason = trans('messages.campaign_not_accepted');
        } elseif ($this->done) {
            $result = false;
            $reason = trans('messages.campaign_finished');
        } elseif ($this->canceled) {
            $result = false;
            $reason = trans('messages.campaign_canceled');
        }

        return [
            'result' => $result,
            'reason' => $reason,
        ];
    }

    public function isCis(): bool
    {
        return $this->country_group === 'cis';
    }

    public function getPriceForUserAttribute(): ?float
    {
        $price = $this->price;
        $prefix = $this->device_type . '_';
        $prices = AppPrice::getPrices();
        if ($this->isCis() && $this->custom_price == 1 && !$this->other_type) {
            $days = $this->days;
            $duration = $this->duration;
            $time_delay = $this->time;
            $delay = '24h';
            switch ($time_delay) {
                case 48:
                    $delay = '48h';
                    break;
                case 72:
                    $delay = '72h';
                    break;
            }

            if ($delay === '48h') {
                if ($days >= 2 && $days <= 10) {
                    $price = $prices[$prefix . $delay . '_price_first_manager'];
                } elseif ($days >= 11 && $days <= 20) {
                    $price = $prices[$prefix . $delay . '_price_second_manager'];
                } elseif ($days >= 21 && $days <= 30) {
                    $price = $prices[$prefix . $delay . '_price_third_manager'];
                } elseif ($days >= 31 && $days <= 50) {
                    $price = $prices[$prefix . $delay . '_price_fourth_manager'];
                }
                //Else for 24h and 72h
            } else {
                if ($days >= 1 && $days <= 6) {
                    $price = $prices[$prefix . $delay . '_price_first_manager'];
                } elseif ($days >= 7 && $days <= 14) {
                    $price = $prices[$prefix . $delay . '_price_second_manager'];
                } elseif ($days >= 15 && $days <= 29) {
                    $price = $prices[$prefix . $delay . '_price_third_manager'];
                } elseif ($days >= 30 && $days <= 50) {
                    $price = $prices[$prefix . $delay . '_price_fourth_manager'];
                }
            }
            $price += $prices[$prefix . 'install_price_manager'];
            $price += $prices[$prefix . $duration . 's_price_manager'];

        }

        if ($this->run_after) {
            $price += Settings::getInstance()->getAttributeValue('run_after_price');
        }

        if ($this->isCis() && $this->custom_price != 0 && $this->custom_price != 1) {
            $price += $this->custom_price;
        }

        return $price;
    }

    public function statistics()
    {
        /*if ($this->attributes['id'])
            return 0;*/
        return $this->hasOne(ApplicationStatistics::class);
    }

    public function getAmountAttribute(): float
    {
        $days_range = $this->time_delay; // Range in days

        try {
            $amount = ($this->days * $this->price) / $days_range;

           if ($this->description_active) {
               $description_price = Settings::getInstance()->getAttributeValue('description_price');
               $amount += $this->limit * $description_price;
            }
//
//            if ($this->clicks) {
//                $clicks_price = Settings::getInstance()->getAttributeValue('click_price');
//                $amount += $this->limit * $clicks_price;
//            }

        } catch (Exception $exception) {
            return 0;
        }


        return (float)number_format($amount, 2, '.', '');
    }

    public function getRateKeywordsAttribute()
    {
        $review = $this->review()->first();
        if ($review) {
            return unserialize($review->keywords);
        } else {
            return [];
        }
    }

    public function getRateTypeAttribute()
    {
        $review = $this->review()->first();
        if ($review) {
            if ($review->comments == 0) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 0;
        }
    }

    public function getAmountForUserAttribute(): float
    {
        if (!$this->isCis() || $this->other_type == 1) {
            $amount = $this->price_for_user * $this->limit;
        } else {
            $amount = $this->expected_price_for_user * $this->limit;

            if ($this->review) {
                $settings = Settings::getInstance(['review_price', 'review_comment_price']);
                $amount += $this->review->rates * $settings->review_price;
                $amount += $this->review->comments * $settings->review_comment_price;
            }

            if ($this->description_active) {
                $description_price = Settings::getInstance(['description_price'])->getAttributeValue('description_price');
                $amount += $this->limit * $description_price;
            }

            if($this->top) {
                $top_price = Settings::getInstance(['top_price'])->getAttributeValue('top_price');
                $amount += $top_price * $this->limit;
            }

        /*    if ($this->clicks) {
                $clicks_price = Settings::getInstance()->getAttributeValue('click_price');
                $amount += $this->limit * $clicks_price;
            }*/
        }

        return (float)number_format($amount, 2, '.', '');
    }

    public function getUsersCount(): int
    {
        if (!$this->attributes['id'] || $this->attributes['limit'] == 0)
            return 0;
        if (($this->other_type == 1 || !$this->isCis()) && $this->statistics()->exists()) {
            $count = $this->statistics->limit;
        } else {
            $count = $this->users()->wherePivot('is_accepted', 1)->count();
        }

        return $count;
    }

    public function getLimitStateAttribute(): string
    {
        return $this->getUsersCount() . '/' . $this->limit;
    }

    public function getTotalRunsAttribute(): int
    {
        if (!$this->attributes['id'] || $this->attributes['limit'] == 0)
            return 0;
        return $this->tasks()->sum('times') ?? 0;
    }

    public function getInstallsTodayAttribute(): int
    {
        $today = Carbon::today()->toDateString();

        return $this->tasks()->where('is_installed', 1)
            ->whereDate('created_at', '=', $today)->count();
    }

    public function getTimeDelayFormattedAttribute(): string
    {
        if ($this->other_type == 1) {
            $label = '3 ' . trans('labels.days');

            return $label;
        }
        if ($this->country_group && $this->country_group === 'cis') {
            switch ($this->time_delay) {
                case 24:
                    $label = trans('labels.24_h');
                    break;
                case 48:
                    $label = trans('labels.48_h');
                    break;
                case 72:
                    $label = trans('labels.72_h');
                    break;
                default:
                    $label = '?';
                    break;
            }
        } else {
            $label = '3 ' . trans('labels.days');
        }

        return $label;
    }

    public function getExpectedPriceForUserAttribute(): float
    {
        $days_range = $this->time_delay / 24; // Range in days

        try {
            $days = ceil($this->days / $days_range);
        } catch (Exception $exception) {
            return 0;
        }

        $prefix = $this->device_type . '_';
        $prices = AppPrice::getPrices();
        $prices[$prefix . 'install_price_manager'];

        return round(($this->price_for_user - $prices[$prefix . 'install_price_manager']) * $days + $prices[$prefix . 'install_price_manager'], 2);
    }

    public function getUserTaskPriceAttribute(): float
    {
        if ($this->time_delay) {
            $delay = $this->time_delay / 24; // Seconds to full day
        } else {
            $delay = 1;
        }

        $price = $this->price;
        // Admin panel
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                $price = $this->price;
            } else {
                $price = $this->price_for_user;
            }
        }

        return $price * $this->days / $delay + $this->install_price;
    }

    public function getAmountWastedAttribute(): float
    {
        if (!$this->attributes['id'] || $this->attributes['limit'] == 0)
            return 0;
        if ($this->country_group !== 'cis') {
            $expectedPriceForUser = $this->price;
        } else {
            $expectedPriceForUser = $this->expected_price_for_user;
        }
        $amount = $expectedPriceForUser * $this->getUsersCount();

        if ($this->review) {
            $settings = Settings::getInstance(['review_price', 'review_comment_price']);

            $reviews_done = $this->tasks()
                ->whereHas('review', function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('state', TaskReview::REVIEW_DONE);
                })->count();

            $comments_done = $this->tasks()
                ->whereHas('review', function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('state', TaskReview::REVIEW_DONE);
                })->count();

            $amount += ($settings->review_price * $reviews_done) + ($settings->review_comment_price * $comments_done);
        }

        if ($this->description_active) {
            $description_price = Settings::getInstance()->getAttributeValue('description_price');
            $amount += $this->users()->count() * $description_price;
        }

        if ($this->clicks) {
            $clicks_price = Settings::getInstance()->getAttributeValue('click_price');
            $amount += $this->users()->count() * $clicks_price;
        }

        return floatval(number_format($amount, 2, '.', ''));
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        $date = Carbon::now();
        if (!is_null($this->created_at)) {
            $date = $this->created_at;
        }

        return $date->format('d-m-Y');
    }

    public function getInstallPriceForUserAttribute()
    {
        $prices = AppPrice::getPrices();

        return $prices['android_install_price_manager'];
    }

    public function setDeferredStartAttribute($value)
    {
        if ($value) {
            $this->attributes['deferred_start'] = Carbon::parse($value);
        } else {
            $this->attributes['deferred_start'] = null;
        }
    }

    /**
     * @param Builder|self $query
     *
     * @return Builder
     */
    public function scopePaid($query)
    {
        return $query->where('paid', '=', true);
    }

    public function getReviewsModerateAttribute(): int
    {
        if (!$this->review) {
            return 0;
        }

        $count = $this->reviewTasks()->whereIn('state', [
            TaskReview::REVIEW_MODERATING,
            TaskReview::COMMENT_MODERATING,
        ])->count();

        return $count;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('moderated', 1)->where('accepted', 1);
    }

}
