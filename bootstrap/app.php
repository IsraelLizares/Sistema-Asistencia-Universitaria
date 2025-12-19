<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DocenteMiddleware;
use App\Http\Middleware\CoordinadorMiddleware;
use App\Http\Middleware\EstudianteMiddleware;
use App\Http\Middleware\FilamentOnlyAdminParametros;
use App\Providers\AuthServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias de middlewares personalizados
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'docente' => DocenteMiddleware::class,
            'coordinador' => CoordinadorMiddleware::class,
            'estudiante' => EstudianteMiddleware::class,
        ]);
    })
    ->withProviders([
        AuthServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
