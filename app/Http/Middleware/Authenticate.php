<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

             
                if ($user->status) {
                    return $next($request);
                } else {
                    
                    Auth::guard($guard)->logout();
                    return redirect()->route('login')
                        ->with('error', 'Tu cuenta ha sido desactivada. Contacte al administrador.')
                        ->setStatusCode(403);
                }
            }
        }

        return redirect()->route('login')
            ->with('error', 'Debes iniciar sesión para acceder a esta página.')
            ->setStatusCode(403);
    }
}