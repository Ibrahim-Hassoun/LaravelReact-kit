<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;



return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "authenticated" => \App\Http\Middleware\ApiAuthenticate::class
        ]);
    })
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->renderable(function (AuthenticationException $e, $request) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated. Token missing or invalid.',
        ], 401);
    });

    $exceptions->renderable(function (TokenInvalidException $e, $request) {
        return response()->json([
            'success' => false,
            'message' => 'Token is invalid.',
        ], 401);
    });

    $exceptions->renderable(function (TokenExpiredException $e, $request) {
        return response()->json([
            'success' => false,
            'message' => 'Token has expired.',
        ], 401);
    });
})->create();
