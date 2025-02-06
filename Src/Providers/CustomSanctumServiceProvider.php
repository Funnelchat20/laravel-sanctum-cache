<?php

namespace LaravelSanctumCache\Providers;

use LaravelSanctumCache\Repositories\CustomTokenRepository;

class CustomSanctumServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CustomTokenRepository::class, function ($app) {
            return new CustomTokenRepository();
        });
    }

    public function boot()
    {
        //
    }
}