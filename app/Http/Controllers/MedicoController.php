<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index(Request $request)
    {
        $query = Medico::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('cui', 'like', "%{$search}%");
        }

        $medicos = $query->get();

        return view('medicos.index', compact('medicos'));
    }

    public function create()
    {
        return view('medicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cui' => 'nullable|string|max:13',
            'especialidad' => 'required|string|max:255',
            'telefono' => 'required|string|max:8',
            'correo' => 'required|string|email|max:255|unique:medicos',
        ]);

        Medico::create($request->all());

        return redirect()->route('medicos.index')->with('success', 'Médico creado exitosamente.');
    }

    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        return view('medicos.edit', compact('medico'));
    }

    public function update(Request $request, $id)
    {
        $medico = Medico::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cui' => 'nullable|string|max:13',
            'especialidad' => 'required|string|max:255',
            'telefono' => 'required|string|max:8',
            'correo' => 'required|string|email|max:255|unique:medicos,correo,'.$medico->id,
        ]);

        $medico->update($request->all());

        return redirect()->route('medicos.index')->with('success', 'Médico actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return redirect()->route('medicos.index')->with('success', 'Médico eliminado exitosamente.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $medicos = Medico::where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('cui', 'LIKE', "%{$query}%")
                    ->orWhere('especialidad', 'LIKE', "%{$query}%")
                    ->get();

        return response()->json($medicos);
    }
}