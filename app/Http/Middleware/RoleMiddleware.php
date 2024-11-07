<?php

namespace App\Http\Middleware;



use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class RoleMiddleware
{
    // app/Http/Middleware/RoleMiddleware.php

public function handle($request, Closure $next, $role)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    
    if (!in_array(Auth::user()->role, (array)$role)) {
        return redirect('/'); 
    }

    return $next($request); 
}

};
