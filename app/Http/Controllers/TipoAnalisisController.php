<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoAnalisis;

class TipoAnalisisController extends Controller
{
    public function index()
    {
        $tiposAnalisis = TipoAnalisis::paginate(8);
        return view('tipos_analisis.index', compact('tiposAnalisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        TipoAnalisis::create($request->all());
        return redirect()->route('tipos-analisis.index')->with('success', 'Tipo de análisis creado exitosamente.');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    $tipoAnalisis = TipoAnalisis::find($id);

    if ($tipoAnalisis) {
        $tipoAnalisis->nombre = $request->input('nombre');
        $tipoAnalisis->save();

        return redirect()->route('tipos-analisis.index')->with('success', 'Tipo de análisis actualizado con éxito.');
    }

    return redirect()->route('tipos-analisis.index')->with('error', 'Tipo de análisis no encontrado.');
}


public function destroy($id)
{
    $tipoAnalisis = TipoAnalisis::find($id);
    
    if (!$tipoAnalisis) {
        return redirect()->route('tipos-analisis.index')->with('error', 'Tipo de análisis no encontrado.');
    }
    
    $tipoAnalisis->delete();
    return redirect()->route('tipos-analisis.index')->with('success', 'Tipo de análisis eliminado exitosamente.');
}
}