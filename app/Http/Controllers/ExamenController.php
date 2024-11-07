<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\TipoAnalisis;
use Illuminate\Http\Request;

class ExamenController extends Controller
{

    public function index()
    {
    $examenes = Examen::paginate(8);
    $tiposAnalisis = TipoAnalisis::all();
    return view('examenes.index', compact('examenes', 'tiposAnalisis'));
    }

    public function create()
    {

    $tiposAnalisis = TipoAnalisis::all();
    return view('examenes.create', compact('tiposAnalisis'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo_analisis_id' => 'required|exists:tipos_analisis,id',
    ]);

    Examen::create($request->all());

    return redirect()->route('examenes.index')->with('success', 'Examen creado con éxito.');
    }

    public function edit($id)
    {
    $examen = Examen::find($id);
    $tiposAnalisis = TipoAnalisis::all(); 

    return view('examenes.edit', compact('examen', 'tiposAnalisis'));
    }


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

    public function destroy($id)
    {
    $examen = Examen::findOrFail($id);
    $examen->delete();

    return redirect()->route('examenes.index')->with('success', 'Examen eliminado con éxito.');
    }

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