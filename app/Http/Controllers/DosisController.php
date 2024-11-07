<?php

namespace App\Http\Controllers;

use App\Models\Dosis;
use App\Models\Vacuna;
use Illuminate\Http\Request;

class DosisController extends Controller
{
    
    public function index()
    {
        $dosis = Dosis::paginate(8); 
        $vacunas = Vacuna::all(); 
        return view('dosis.index', compact('dosis', 'vacunas'));
    }

    public function create()
    {
        $vacunas = Vacuna::all(); 
        return view('dosis.create', compact('vacunas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'vacuna_id' => 'required|exists:vacunas,id',
        ]);

        Dosis::create($request->all());

        return redirect()->route('dosis.index')->with('success', 'Dosis creada exitosamente.');
    }

    public function edit($id)
    {
        $dosis = Dosis::findOrFail($id);
        $vacunas = Vacuna::all(); 

        return view('dosis.edit', compact('dosis', 'vacunas'));
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'vacuna_id' => 'required|exists:vacunas,id',
        ]);

        $dosis = Dosis::findOrFail($id);
        $dosis->nombre = $request->nombre;
        $dosis->vacuna_id = $request->vacuna_id;
        $dosis->save();

        return redirect()->route('dosis.index')->with('success', 'Dosis actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $dosis = Dosis::findOrFail($id);
        $dosis->delete();

        return redirect()->route('dosis.index')->with('success', 'Dosis eliminada exitosamente.');
    }

    public function getDosisByVacuna($vacunaId)
    {
        $dosis = Dosis::where('vacuna_id', $vacunaId)->get();
        return response()->json($dosis);
    }

    public function searchByVacuna(Request $request)
    {
        $dosis = Dosis::where('vacuna_id', $request->vacuna_id)->get();
        return response()->json($dosis);
    }
}