<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la vista de enfermeras
        return view('nurses.index'); // Ajusta la vista según tu estructura de carpetas
    }
}
