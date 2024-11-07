<?php

namespace App\Http\Controllers;

use App\Models\Vacuna;
use Illuminate\Http\Request;

class VacunaController extends Controller
{
    public function index()
    {
        $vacunas = Vacuna::paginate(8);
        return view('vacunas.index', compact('vacunas'));
    }

    public function create()
    {
        return view('vacunas.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:vacunas|max:255',
        ]);

        Vacuna::create($request->all());
        return redirect()->route('vacunas.index')->with('success', 'Vacuna creada exitosamente.');
    }

    public function edit(Vacuna $vacuna)
    {
        return view('vacunas.edit', compact('vacuna'));
    }

    public function update(Request $request, Vacuna $vacuna)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:vacunas,nombre,' . $vacuna->id,
        ]);

        $vacuna->update($request->all());
        return redirect()->route('vacunas.index')->with('success', 'Vacuna actualizada exitosamente.');
    }

    public function destroy(Vacuna $vacuna)
    {
        $vacuna->delete();
        return redirect()->route('vacunas.index')->with('success', 'Vacuna eliminada exitosamente.');
    }
}