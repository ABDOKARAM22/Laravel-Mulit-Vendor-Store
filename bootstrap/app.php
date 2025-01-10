<?php

use App\Http\Middleware\CheckLastActivityTime;
use App\Http\Middleware\MarkNotificationsAsRead;
use App\Http\Middleware\UserType;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user_type' => UserType::class,
        ]);

        $middleware->appendToGroup('web', [
            CheckLastActivityTime::class,
            MarkNotificationsAsRead::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
