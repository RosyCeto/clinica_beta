<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Aquí puedes personalizar la redirección después del inicio de sesión
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión

        return redirect('/login'); // Redirige a la página de inicio de sesión
    }



    protected function authenticated(Request $request, $user)
{
    if (!$user->status) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada. Contacte al administrador.');
    }

    // Verifica si el rol existe y redirige según el rol
    if (isset($user->role)) {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'doctor':
                return redirect()->route('doctor.dashboard');
            case 'nurse':
                return redirect()->route('nurse.dashboard');
            case 'lab_tech':
                return redirect()->route('lab.tech.dashboard');
            default:
                return redirect('/home');
        }
    }

    // Redirigir a una ruta por defecto si el rol no está definido
    return redirect('/home');
}

}
