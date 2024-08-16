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
        // Per il middleware custom auth
        $middleware->appendToGroup('auth.custom', \App\Http\Middleware\RedirectIfNotAuthenticated::class);
        // Per il middleware admin
        $middleware->appendToGroup('admin', \App\Http\Middleware\AdminMiddleware::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
