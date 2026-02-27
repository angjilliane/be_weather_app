<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Middleware\SubstituteBindings;

use App\Exceptions\WeatherApiException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function ($exceptions) {
        $exceptions->render(function (WeatherApiException $e, $request) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 503);
        });
    
        $exceptions->render(function (Throwable $e, $request) {
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation Error!',
                    'error' => $e->getMessage(),
                ], $e->getCode() ?: 422);
                return null;
            }

            return response()->json([
                'error' => 'Internal Server Error',
            ], 500);
        });
    })->create();
