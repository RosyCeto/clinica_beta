<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        Auth::logout(); 

        return redirect('/login'); 
    }

    protected function authenticated(Request $request, $user)
{
    if (!$user->status) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada. Contacte al administrador.');
    }

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

    return redirect('/login');
    }
}