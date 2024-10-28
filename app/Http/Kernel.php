<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'auth.custom' => \App\Http\Middleware\Authenticate::class,
       
        
        // Otros middlewares
    ];

    protected $middleware = [
        // Otros middlewares...
        \App\Http\Middleware\NoCache::class,
    ];
    
    
    
}

