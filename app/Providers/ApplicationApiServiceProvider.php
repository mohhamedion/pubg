<?php

namespace App\Providers;

use App\Contracts\Services\ApplicationApiServiceInterface;
use App\Services\ApplicationApiService;
use Illuminate\Support\ServiceProvider;

class ApplicationApiServiceProvider extends ServiceProvider
{
    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApplicationApiServiceInterface::class, ApplicationApiService::class);
    }
}
