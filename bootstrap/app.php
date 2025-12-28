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
    ->withMiddleware(function (Middleware $middleware): void {
        // Регистрируем middleware для отслеживания посетителей
        // appendToGroup('web', ...) добавляет middleware в группу 'web'
        // Это значит что TrackVisitor будет запускаться для всех веб-страниц
        $middleware->appendToGroup('web', \App\Http\Middleware\TrackVisitor::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
