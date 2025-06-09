<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware custom per autenticazione
        $middleware->appendToGroup('auth.custom', \App\Http\Middleware\RedirectIfNotAuthenticated::class);
        // Middleware per ruoli admin
        $middleware->appendToGroup('admin', \App\Http\Middleware\AdminMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule
            ->command('app:calculate-all-ranking-averages')
            ->weekly()
            ->at('00:00')
            ->name('weekly-log')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/scheduler.log'));
    })
    ->create();
