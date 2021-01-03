<?php

namespace App\Models;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Traits\AmountAttributeTrait;
use App\Traits\CurrencyTrait;
use App\Traits\UserIdentifierAttributeTrait;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $method
 * @property string $phone
 * @property float $amount
 * @property float $amount_clean
 * @property string|null $response
 * @property string|null $state
 * @property int $manual
 * @property int $locked
 * @property int $restored
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string $amount_formatted
 * @property-read null|string $currency
 * @property-read array $status_for_view
 * @property-read mixed $user_identifier
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction getPendingCount()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction getRejectedCount()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction getSentCount()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction getSuccessfulCount()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction orderByImportance()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction searchByDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction searchById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction searchByMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction searchByStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction searchByUserIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction sort($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmountClean($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereRestored($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUserId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{

    use CurrencyTrait, AmountAttributeTrait, UserIdentifierAttributeTrait;

    const AMOUNT_INSUFFICIENT = 0;
    const AMOUNT_UNDER_LIMIT = 1;
    const AMOUNT_OK = 2;

    const METHOD_MANUAL = 'manual';

    const STATUS_OK = 'ok';
    const STATUS_SENT = 'snd';
    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'err';
    const METHOD_IDS = [
        25344 => 'Yandex.Money',
        26808 => 'QIWI',
        1136053 => 'Payeer',
        1652561 => 'OkPay',
        24898938 => 'BeeLine',
        24899291 => 'MTC',
        24899391 => 'Megafone',
        57378077 => 'Yandex.Money',
        57568699 => 'VISA',
        57644634 => 'MasterCard',
        57766314 => 'Maestro/Cirrus',
        60792237 => 'QIWI',
        67629952 => 'BitCoin',
        87893285 => 'AdvCash',
        95877310 => 'Tele 2',
        117146509 => 'VISA',
        117650874 => 'MasterCard',
        117653267 => 'Maestro/Cirrus',
        159619790 => 'PAYEER® MasterCard',
        187728448 => 'BitCoin',
        189279909 => 'BitCoin',
        244385496 => 'VISA',
        244773909 => 'MasterCard',
        283423641 => 'Bitcoin',
    ];
    protected $table = 'transactions';
    protected $guarded = ['id'];
    protected $appends = [
        'status_for_view',
        'user_identifier',
        'amount_formatted'
    ];
    protected $hidden = [
        'user'
    ];

    protected $casts = [
        'manual' => 'boolean',
        'locked' => 'boolean',
        'restored' => 'boolean',
        'amount' => 'float',
        'amount_clean' => 'float',
    ];

    /**
     * @param float $amt
     *
     * @return float
     */
    /*public static function getCleanAmount($amt): float
    {
        $settings = Settings::getInstance();
        $commission = $settings->withdraw_commission;
        $amtClean = $amt * ((100 - $commission) / 100);

        return (float) number_format($amtClean, 2, '.', '');
    }*/

    /**
     * Returns count of pending transactions
     *
     * @param Builder|self $query
     *
     * @return Transaction|Builder
     */
    public static function scopeGetPendingCount($query)
    {
        return $query->whereState(self::STATUS_PENDING);
    }

    /**
     * Returns count of rejected transactions
     *
     * @param Builder|self $query
     *
     * @return Transaction|Builder
     */
    public static function scopeGetRejectedCount($query)
    {
        return $query->whereState(self::STATUS_REJECTED);
    }

    /**
     * Returns count of successful transactions
     *
     * @param Builder|self $query
     *
     * @return Transaction|Builder
     */
    public static function scopeGetSuccessfulCount($query)
    {
        return $query->whereState(self::STATUS_OK);
    }

    /**
     * Returns count of sent transactions
     *
     * @param Builder|self $query
     *
     * @return Transaction|Builder
     */
    public static function scopeGetSentCount($query)
    {
        return $query->whereState(self::STATUS_SENT);
    }

    /**
     * Transaction belongs to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $price
     *
     * @return float
     */
    public function getAmountCleanAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    /**
     * @param $price
     */
    public function setAmountCleanAttribute($price)
    {
        $this->attributes['amount_clean'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }

    /**
     * @return string
     */
    public function getAmountFormattedAttribute(): string
    {
        return $this->getAttribute('amount') . ' ' . app(CurrencyServiceInterface::class)->getCurrency();
    }

    /**
     * @return array
     */
    public function getStatusForViewAttribute(): array
    {
        return self::getStatusForView($this->getAttribute('state'));
    }

    /**
     * @param string $status
     *
     * @return array
     */
    public static function getStatusForView($status): array
    {
        $class = null;
        $label = null;
        switch ($status) {
            case self::STATUS_OK:
                $class = 'success';
                $label = trans('labels.transactions.singular.successful');
                break;
            case self::STATUS_SENT:
                $class = 'primary';
                $label = trans('labels.transactions.in_progress');
                break;
            case self::STATUS_REJECTED:
                $class = 'danger';
                $label = trans('labels.transactions.singular.rejected');
                break;
            case self::STATUS_PENDING:
                $class = 'warning';
                $label = trans('labels.transactions.pending');
                break;
            default:
                $class = 'new';
                $label = trans('labels.transactions.singular.new');
                break;
        }

        return [
            'class' => $class,
            'label' => $label,
        ];
    }

    /**
     * Order by state importance
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeOrderByImportance($query)
    {
        return $query->orderBy(
            DB::raw(
                'case when state= "' . self::STATUS_PENDING . '" then 1 
                      when state= "' . self::STATUS_SENT . '" then 2
                      when state= "' . self::STATUS_OK . '" then 3
                      when state= "' . self::STATUS_REJECTED . '" then 4
                      when state is NULL then 999
                end'
            )
        );
    }

    /**
     * @param Builder|self $query
     * @param string $value
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByUserIdentifier($query, $value)
    {
        return $query->whereHas('user', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('email', 'like', '%' . $value . '%');
        })->orWhereHas('user', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('device_token', 'like', '%' . $value . '%');
        })->orWhereHas('user', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('login', 'like', '%' . $value . '%');
        })->orWhereHas('user', function ($query) use ($value) {
            /** @var Builder $query */
            $query->where('name', 'like', '%' . $value . '%');
        });
    }

    /**
     * @param Builder $query
     * @param string $value
     *
     * @return Builder mixed
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByStatus($query, string $value)
    {
        return $query->where('state', '=', $value);
    }

    /**
     * @param Builder $query
     * @param string $value
     *
     * @return Builder mixed
     * @throws \InvalidArgumentException
     */
    public function scopeSearchByMethod($query, $value)
    {
        return $query->where('method', 'like', '%' . $value . '%');
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
     * @param Builder|self $query
     * @param string $value
     *
     * @return Builder|self
     * @throws \InvalidArgumentException
     */
    public function scopeSearchById($query, $value)
    {
        return $query->whereId($value);
    }

    /**
     * Sort function
     *
     * @param Builder|self $query
     * @param              $column
     * @param              $order
     *
     * @return Builder
     */
    public function scopeSort($query, $column, $order)
    {
        if ($column) {
            $query = $query->orderBy($column, $order);
        } else {
            $query->orderByImportance()->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function getMethodAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Debit from user's balance
     */
    public function debitRequest()
    {
        $this->user->update([
            'balance' => $this->user->balance - $this->amount
        ]);
    }

    /**
     * Restore user's balance if transaction rejected
     */
    public function restoreRequest()
    {
        $this->update([
            'state' => self::STATUS_REJECTED,
            'locked' => true,
            'restored' => true,
        ]);
//        $this->user->update([
//            'balance' => $this->user->balance + $this->amount
//        ]);
    }
}
