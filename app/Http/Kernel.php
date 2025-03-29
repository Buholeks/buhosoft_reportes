<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Los middleware globales que se ejecutan para cada petición HTTP.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Otros middleware globales de Laravel
        // \App\Http\Middleware\TrustProxies::class,
        // \Fruitcake\Cors\HandleCors::class,
        // \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // \App\Http\Middleware\TrimStrings::class,
        // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Grupos de middleware.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            // Middleware propios de las rutas web (incluye sesiones, cookies, etc.)
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // Otros middleware del grupo web...
            // Puedes incluir el middleware de sucursal aquí si quieres que aplique a todo el grupo web:
        ],

        'api' => [
            // Middleware para rutas API
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware asignados a rutas individuales mediante alias.
     *
     * @var array<string, class-string|string>
     */ protected $routeMiddleware = [
        // Otros middleware...
        'check.sucursal' => \App\Http\Middleware\CheckSucursalSelected::class,
    ];
}
