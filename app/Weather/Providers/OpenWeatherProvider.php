<?php 

namespace App\Weather\Providers;

use App\Weather\Contracts\WeatherProvider;
use App\Exceptions\WeatherApiException;
use Illuminate\Support\Facades\Http;

class OpenWeatherProvider implements WeatherProvider
{
    public function getData(string $city): array
    { 
        $serviceApiUrl = config('services.openweather.url');
        $apiKey = config('services.openweather.key');
        $serviceParams =  [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ];

        $response = Http::timeout(5)->get($serviceApiUrl, $serviceParams);
        $body = $response->json();
        
        if ($response->failed()) {
            throw new WeatherApiException(
                $body['message'] ?? 'Weather provider unavailable.',
                $response->status()
            );
        }

        if (!isset($body['main']['temp'], $body['weather'][0]['description'])) {
            throw new WeatherApiException(
                'Unexpected response from weather provider.',
                500
            );
        }

        return [
            'city' => $city,
            'temperature' => (float) $body['main']['temp'],
            'weather_description' => (string) $body['weather'][0]['description'],
            'timestamp' => now()->toDateTimeString(),
            'source' => 'external',
        ];
    }
}