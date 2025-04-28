<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    // $app->withMiddleware([
    //     // Middleware bawaan Laravel 11
    //     \Illuminate\Routing\Middleware\SubstituteBindings::class,
    
    //     // Middleware custom untuk admin
    //     \App\Http\Middleware\AdminMiddleware::class,
    // ]);

    $app->withMiddleware([
        // Middleware Laravel 11
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    
        // Middleware custom
        \App\Http\Middleware\AdminMiddleware::class,
        \App\Http\Middleware\UserMiddleware::class,
    ]);
    
