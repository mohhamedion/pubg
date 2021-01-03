<?php

namespace App\Providers;

use App\Contracts\Services\CampaignServiceInterface;
use App\Services\CampaignService;
use Illuminate\Support\ServiceProvider;

class CampaignServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap application service.
     *
     * @return void
     */
    public function boot()
    {
        app()->make(CampaignServiceInterface::class);
    }

    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CampaignServiceInterface::class, CampaignService::class);
    }
}
