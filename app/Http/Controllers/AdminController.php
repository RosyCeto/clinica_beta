<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class AdminController extends Controller
{
    public function index()
    {
        // Obtener el número total de usuarios
        $totalUsuarios = User::count();

        // Obtener el número de usuarios registrados en el último mes
        $nuevosUsuarios = User::where('created_at', '>=', now()->subMonth())->count();

        // Retornar la vista del dashboard con los datos de usuarios
        return view('admin-dashboard', compact('totalUsuarios', 'nuevosUsuarios'));
    }
}
