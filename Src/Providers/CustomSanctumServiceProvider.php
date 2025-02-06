<?php

namespace LaravelSanctumCache\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelSanctumCache\Repositories\CustomTokenRepository;

class CustomSanctumServiceProvider extends ServiceProvider
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