<?php

namespace App\Weather\Contracts;

interface WeatherProvider
{
    public function getData(string $city);
}