<?php

namespace App\Traits;

use App\Contracts\Services\CurrencyServiceInterface;

trait PriceTrait
{

    public function getPriceAttribute($price): float
    {
        if (is_null($price)) {
            return 0;
        }

        return app(CurrencyServiceInterface::class)->convertFromRub($price);
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = app(CurrencyServiceInterface::class)->convertToRub($price);
    }
}
