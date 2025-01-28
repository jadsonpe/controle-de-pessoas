<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * O aplicativo global HTTP middleware stack.
     *
     * Esses middleware são executados em todas as solicitações para o aplicativo.
     *
     * @var array
     */
    protected $middleware = [
       // \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
       // \App\Http\Middleware\LoadConfigurations::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\App\Http\Middleware\Authenticate::class,
       // \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        //\Illuminate\Foundation\Http\Middleware\ThrottleRequests::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];

    /**
     * O middleware do grupo de roteamento de aplicativo.
     *
     * Esses middleware são executados durante o processamento de solicitações via roteamento.
     *
     * @var array
     */
    protected $routeMiddleware = [
        //'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\IsAdmin::class, // Middleware de admin que criamos
        //'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];
}
