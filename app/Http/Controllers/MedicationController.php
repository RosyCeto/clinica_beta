<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Medication::query();

        // Búsqueda por nombre o código
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', "%$search%")
                  ->orWhere('codigo', 'LIKE', "%$search%");
        }

        // Paginación de 10 elementos
        $medications = $query->paginate(10);

        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        return view('medications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fecha_caducidad' => 'required|date'
        ]);

        Medication::create($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicamento agregado correctamente.');
    }

    public function edit(Medication $medication)
    {
        return view('medications.edit', compact('medication'));
    }

    public function update(Request $request, Medication $medication)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'fecha_caducidad' => 'required|date'
        ]);

        $medication->update($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy(Medication $medication)
    {
        try {
            $medication->delete();
            return redirect()->route('medications.index')->with('success', 'Medicamento eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('medications.index')->with('error', 'Error al eliminar el medicamento: ' . $e->getMessage());
        }
    }

    public function recordEntry(Request $request, Medication $medication)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $medication->increment('cantidad', $request->cantidad);

        return redirect()->route('medications.index')->with('success', 'Entrada de medicamento registrada correctamente.');
    }

    public function handleExit(Request $request, Medication $medication)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        if ($medication->cantidad >= $request->cantidad) {
            $medication->decrement('cantidad', $request->cantidad);
            return redirect()->route('medications.index')->with('success', 'Salida de medicamento registrada correctamente.');
        } else {
            return redirect()->route('medications.index')->with('error', 'No hay suficiente cantidad disponible.');
        }
    }

    public function search(Request $request)
{
    $query = $request->input('query');
    $medication = Medication::where('nombre', 'like', "%{$query}%")
        ->orWhere('codigo', 'like', "%{$query}%")
        ->first(); // Solo buscamos el primer medicamento que coincida

    if ($medication) {
        return response()->json($medication);
    } else {
        return response()->json(['error' => 'Medicamento no encontrado'], 404);
    }
}

public function sale(Request $request)
{
    $request->validate([
        'medication_id' => 'required|exists:medications,id',
        'cantidad' => 'required|integer|min:1',
    ]);

    $medication = Medication::findOrFail($request->medication_id);

    // Verificar si hay suficiente cantidad disponible
    if ($medication->cantidad >= $request->cantidad) {
        $medication->decrement('cantidad', $request->cantidad);
        return redirect()->route('medications.index')->with('success', 'Salida de medicamento registrada correctamente.');
    } else {
        return redirect()->route('medications.index')->with('error', 'No hay suficiente cantidad disponible.');
    }
}


}
