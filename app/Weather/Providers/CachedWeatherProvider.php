<?php

namespace App\Weather\Providers;

use App\Weather\Contracts\WeatherProvider;
use Illuminate\Support\Facades\Cache;

class CachedWeatherProvider implements WeatherProvider
{
    public function __construct(
        private WeatherProvider $provider
    ) {}

    public function getData(string $city): array
    {
        $city = strtolower($city);
        $cacheKey = "weather_{$city}";
        $cacheTTL = config('services.openweather.cache.ttl_seconds', 600);

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            $cached['source'] = 'cache';
            return $cached;
        }
    
        $data = $this->provider->getData($city);
    
        Cache::put($cacheKey, $data, $cacheTTL);
    
        return $data;
    }
}