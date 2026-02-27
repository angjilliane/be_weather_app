<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\WeatherService;
use App\Weather\Providers\CachedWeatherProvider;
use App\Weather\Providers\OpenWeatherProvider;


class WeatherController extends Controller
{
    public function __construct(
        private WeatherService $service
    ) {}

    private function validateCity(string $city): string
    {
        Validator::make(
            ['city' => $city],
            [
                'city' => [
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                    'regex:/^[\pL\s\.\'\-]+$/u'
                ],
            ]
        )->validate();

        return trim($city);
    }

    public function getByCity(string $city)
    {
        $city = $this->validateCity($city);

        return response()->json(
            $this->service->getWeather($city)
        );
    }

    public function getCachedByCity(string $city)
    {
        $city = $this->validateCity($city);

        $provider = new CachedWeatherProvider(
            new OpenWeatherProvider()
        );
    
        $service = new \App\Services\WeatherService($provider);
    
        return response()->json(
            $service->getWeather($city)
        );
        
    }

   
}