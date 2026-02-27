<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    public function test_weather_endpoint_returns_data()
    {
        Http::fake([
            '*' => Http::response([
                'main' => ['temp' => 28],
                'weather' => [
                    ['description' => 'clear sky']
                ]
            ], 200)
        ]);

        $response = $this->getJson('/weather/Manila');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'city',
                'temperature',
                'weather_description',
                'timestamp',
                'source'
            ]);
    }

    public function test_weather_endpoint_handles_external_failure()
    {
        Http::fake([
            '*' => Http::response([], 500)
        ]);

        $response = $this->getJson('/weather/Manila');

        $response->assertStatus(500)
            ->assertJson([
                'error' => 'Weather provider unavailable.'
            ]);
    }

    public function test_cached_weather_returns_cache_on_second_call()
    {
        Config::set('cache.default', 'file');

        Http::fake([
            '*' => Http::response([
                'main' => ['temp' => 30],
                'weather' => [
                    ['description' => 'cloudy']
                ]
            ], 200),
        ]);
    
        $this->getJson('/weather/Manila/cached');
        $response = $this->getJson('/weather/Manila/cached');
    
        $response->assertStatus(200)
            ->assertJson([
                'source' => 'cache'
            ]);
    }

    public function test_weather_validation_fails_for_invalid_city()
    {
        $response = $this->getJson('/weather/123');

        $response->assertStatus(422);
    }
}
