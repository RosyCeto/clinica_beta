<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Aquí puedes retornar una vista del dashboard de administrador
        return view('admin-dashboard'); // Asegúrate de tener una vista 'admin/dashboard.blade.php'
    }
}
