<?php

namespace App\Providers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Services\CurrencyService;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap application service.
     *
     * @return void
     */
    public function boot()
    {
        app()->make(CurrencyServiceInterface::class);
    }

    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyServiceInterface::class, CurrencyService::class);
    }
}
