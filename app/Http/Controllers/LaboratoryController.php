<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function index()
    {
        // Aquí puedes retornar una vista para el laboratorio
        return view('laboratory.index'); // Asegúrate de tener una vista 'laboratory/index.blade.php'
    }
}
