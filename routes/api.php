<?php

use App\Http\Controllers\WeatherController;


Route::get('/weather/{city}/cached', [WeatherController::class, 'getCachedByCity']);
Route::get('/weather/{city}', [WeatherController::class, 'getByCity']);
