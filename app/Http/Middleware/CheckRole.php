// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->user() || auth()->user()->role !== $role) {
            return redirect('/'); // Redirigir a inicio si no tiene permiso
        }
        return $next($request);
    }
}
