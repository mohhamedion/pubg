<?php

namespace App\Traits;

use App\Contracts\Services\CurrencyServiceInterface;

trait CurrencyTrait
{

    /**
     * Get currency for country
     *
     * @return string
     */
    public function getCurrencyAttribute(): string
    {
        return app(CurrencyServiceInterface::class)->getCurrency();
    }
}
