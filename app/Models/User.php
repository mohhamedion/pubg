<?php

namespace App\Models;

use App\Contracts\Services\CurrencyServiceInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const REFERRAL_SYSTEM_FIRST = 1;
    const REFERRAL_SYSTEM_SECOND = 2;

    const ROLES = [
        'admin' => 'Администратор',
        'manager' => 'Менеджер',
        'editor' => 'Редактор',
        'user' => 'Пользователь',
    ];

    const BANS = [
        'balance_cheat' => 0,
        'referral_cheat'=> 1,
        'violation_of_rules' => 2,
        'spam' => 3,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'token',
    ];

    protected $appends = [
        'role_name',
        'identifier',
        'balance_formatted',
        //'referrals_count',
        //'rating'
    ];
	
	public function __construct()
	{
		$this->country_id = 220;
	}

    public function country()
    {
        return $this->belongsTo(Country::class);
		return 220;
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function referralPaid()
    {
        return $this->belongsToMany(User::class, 'referral_awards', 'referrer_id', 'referral_id')
            ->withPivot('paid')
            ->withTimestamps();
    }

    public function awards()
    {
        return $this->hasMany(Award::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'user_quizzes','user_id', 'quiz_id')
            ->withPivot( 'today_times', 'limit', 'times', 'earned', 'is_available', 'last_open')->withTimestamps();
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'user_games','user_id', 'game_id')
            ->withPivot( 'today_times', 'limit', 'times', 'today_earned', 'earned', 'best_score', 'is_available', 'last_open')->withTimestamps();
    }

    public function level()
    {
        return $this->hasOne(UserLevel::class);
    }

    public function videoLimit()
    {
        return $this->hasOne(UserVideoLimit::class);
    }

    public function marathons()
    {
        return $this->belongsToMany(Marathon::class, 'users_marathon','user_id', 'marathon_id')
            ->withPivot('is_available', 'times', 'failed', 'last_open', 'user_current_day', 'done')
            ->withTimestamps();
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_tasks','user_id', 'task_id')
            ->withPivot('ud', 'times', 'failed_times', 'is_accepted', 'is_available', 'is_rating_available',
                'is_done', 'last_open', 'updated_at', 'is_checked', 'is_installed', 'date', 'earned', 'cards', 'progress_bar')
            ->withTimestamps();
    }

    public function bonusCards()
    {
        return $this->belongsToMany(BonusCard::class, 'user_bonus_cards','user_id', 'bonus_card_id')
            ->withPivot('used');
    }

    public function CardTransactions()
    {
        return $this->belongsToMany(CardTransaction::class, 'user_card_transactions','user_id', 'card_transaction_id')
            ->withPivot('used', 'amount', 'ud');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'user_videos','user_id', 'video_id')
            ->withPivot( 'views', 'today_views', 'earned', 'is_available', 'last_open')->withTimestamps();
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'user_partners','user_id', 'partner_id')
            ->withPivot('times', 'earned')->withTimestamps();
    }

    public function links()
    {
        return $this->belongsToMany(Link::class, 'user_links','user_id', 'link_id');
    }

    public function getBalanceAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getReferralBalanceAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getDuringAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getPaidAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    public function getReferralPaidAttribute($value)
    {
        return (float) number_format($value, 2, '.', '');
    }

    /**
     * User belongs to roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Builder|Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id');
    }

    /**
     * Validate is certain user has role.
     *
     * @param string $role_name
     *
     * @return bool
     */
    public function hasRole(string $role_name): bool
    {
        return $this->roles()->first()->name === $role_name;
    }

    /**
     * Get user role id attribute
     *
     * @return int
     */
    public function getRoleAttribute(): int
    {
        return $this->roles()->first()->id;
    }

    /**
     * Get user role label name attribute
     *
     * @return string|null
     */
    public function getRoleNameAttribute(): ?string
    {
        $role = $this->roles()->first();

		if(\App::isLocale('ru'))
		{
			return $role ? $role->display_name : null;
		} else {
			return $role ? $role->display_name_en : null;
		}
        
    }

    public function getIdentifierAttribute(): ?string
    {
        $identifier = null;
        $type = null;
        if ($this->email) {
            $type = 'E-mail';
            $identifier = $this->email;
        } elseif ($this->name) {
            $type = trans('labels.name');
            $identifier = $this->name;
        } elseif ($this->login) {
            $type = trans('labels.login');
            $identifier = $this->login;
        } else {
            $type = trans('labels.device_token');
            $identifier = $this->device_token;
        }

        return "$identifier ($type)";
    }

    public function getBalanceFormattedAttribute()
    {
        $totalBalance = $this->balance;

        return $totalBalance . ' ' . app(CurrencyServiceInterface::class)->getCurrency();
    }

    /**
     * @param Builder|self $query
     * @param string $value
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByRole($query, $value)
    {
        return $query->whereHas('roles', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('name', 'like', '%' . $value . '%');
        });
    }

    public function balanceReplenishments()
    {
        return $this->hasMany(UserBalanceReplenishment::class);
    }

    public function taskReviews()
    {
        return $this->hasMany(TaskReview::class);
    }

    public function logAward($amount, $referral_system, $appId, $referralId = null)
    {
        $award = new Award([
            'amount' => $amount,
            'referral_system' => $referral_system,
            'application_id' => $appId,
            'referral_id' => $referralId,
        ]);
        $this->awards()->save($award);
    }

    public function specialOffers()
    {
        return $this->belongsToMany(SpecialOffer::class, 'user_special_offer_pivot')
            ->withPivot('id', 'amount', 'search_query', 'package_name');
    }

    public function readArticles()
    {
        return $this->belongsToMany(Article::class, 'user_article_read_pivot', 'user_id', 'article_id');
    }

    public function scopeSearchByUserIdentifier($query, $value)
    {
        return $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    public function scopeSort($query, $column, $order)
    {
        if ($column) {
            if ($column === 'referrals_count') {
                $query = $query->sortByReferralsCount($order);
            } elseif ($column === 'role_name') {
                $query = $query->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->orderBy('role_user.role_id', $order);
            } else {
                $query = $query->orderBy($column, $order);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function scopeSortByReferralsCount($query, $order)
    {
        return $query->leftJoin('users as referrals', 'referrals.referrer_id', '=', 'users.id')
            ->selectRaw('users.*, count(referrals.referrer_id) as referrals_count')
            ->groupBy('referrals.referrer_id')
            ->orderBy('referrals_count', $order);
    }
}
