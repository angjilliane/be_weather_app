<?php

namespace App\Services;

use App\Weather\Contracts\WeatherProvider;

class WeatherService
{
    public function __construct(
        private WeatherProvider $provider
    ) {}

    public function getWeather(string $city)
    {
        return $this->provider->getData($city);
    }
}