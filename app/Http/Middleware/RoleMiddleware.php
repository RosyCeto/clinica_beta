<?php

namespace App\Http\Middleware;



use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Asegúrate de que estás importando el modelo de usuario

class RoleMiddleware
{
    // app/Http/Middleware/RoleMiddleware.php

public function handle($request, Closure $next, $role)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    // Verificar si el rol del usuario autenticado está en la lista de roles permitidos
    if (!in_array(Auth::user()->role, (array)$role)) {
        return redirect('/'); // Redirigir si no tiene el rol adecuado
    }

    return $next($request); // Permitir el acceso si tiene el rol adecuado
}

};
