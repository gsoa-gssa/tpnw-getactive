<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\SetAppLocale::class);
    })
    ->withSchedule(function (Schedule $schedule){
        $schedule->command('contacts:assign-cantons --y')->cron("0-59/5 * * * *")
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/contacts-assign-cantons.log'));
        $schedule->command('contacts:autoassign --y')->cron("3-59/5 * * * *")
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/contacts-autoassign.log'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
