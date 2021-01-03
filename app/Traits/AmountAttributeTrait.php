<?php

namespace App\Traits;

use App\Contracts\Services\CurrencyServiceInterface;

trait AmountAttributeTrait
{

    public function getAmountAttribute($price): float
    {
        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setAmountAttribute($price): void
    {
        $this->attributes['amount'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }
}
