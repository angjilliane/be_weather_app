<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class WeatherApiException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => 'Invalid data',
            'error' => $this->getMessage(),
        ], $this->getCode() ?: 503);
    }
}