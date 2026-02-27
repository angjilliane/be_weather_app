<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Weather\Contracts\WeatherProvider;
use App\Weather\Providers\OpenWeatherProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            WeatherProvider::class,
            OpenWeatherProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
