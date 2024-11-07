<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cita;

class EliminarCitasPasadas
{
    public function handle($request, Closure $next)
    {
        Cita::where('fecha', '<', now())->delete();
        
        return $next($request);
    }
}
