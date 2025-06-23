<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GeocodingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GeocodingService::class, function ($app) {
            return new GeocodingService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
