<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\TipoAnalisis;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    // Mostrar todos los exámenes
    public function index()
{
    $examenes = Examen::paginate(8);
    $tiposAnalisis = TipoAnalisis::all();
    return view('examenes.index', compact('examenes', 'tiposAnalisis'));
}


    // Mostrar el formulario para crear un nuevo examen
    public function create()
{
    // Cambia $tipos_analisis a $tiposAnalisis para ser consistente
    $tiposAnalisis = TipoAnalisis::all();
    return view('examenes.create', compact('tiposAnalisis'));
}

    // Guardar un nuevo examen
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo_analisis_id' => 'required|exists:tipos_analisis,id',
    ]);

    Examen::create($request->all());

    return redirect()->route('examenes.index')->with('success', 'Examen creado con éxito.');
}

    // Mostrar el formulario para editar un examen existente
    public function edit($id)
{
    $examen = Examen::find($id);
    $tiposAnalisis = TipoAnalisis::all(); // Suponiendo que tienes este modelo

    return view('examenes.edit', compact('examen', 'tiposAnalisis'));
}


    // Actualizar un examen existente
    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo_analisis_id' => 'required|exists:tipos_analisis,id',
    ]);

    $examen = Examen::findOrFail($id);
    $examen->nombre = $request->nombre;
    $examen->tipo_analisis_id = $request->tipo_analisis_id;
    $examen->save();

    return redirect()->route('examenes.index')->with('success', 'Examen actualizado con éxito');
}

    // Eliminar un examen
    public function destroy($id)
{
    $examen = Examen::findOrFail($id);
    $examen->delete();

    return redirect()->route('examenes.index')->with('success', 'Examen eliminado con éxito.');
}
    // Método para obtener exámenes según el tipo de análisis (para el formulario de creación o edición)
    public function getExamenesByTipo($tiposAnalisisId)
    {
        $examenes = Examen::where('tipo_analisis_id', $tiposAnalisisId)->get();
        return response()->json($examenes);
    }


    public function searchByTipoAnalisis(Request $request)
{
    $examenes = Examen::where('tipo_analisis_id', $request->tipo_analisis_id)->get();
    return response()->json($examenes);
}

}