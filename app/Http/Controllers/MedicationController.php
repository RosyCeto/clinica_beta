<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MedicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Medication::query();

        // Búsqueda por nombre o código
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', "%$search%")
                  ->orWhere('codigo', 'LIKE', "%$search%"); // Cambiado a buscar por código
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
            'codigo' => 'required|string|max:255', // Validación del nuevo campo
            'cantidad' => 'required|integer|min:1', // Añadido mínimo 1
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
            'codigo' => 'required|string|max:255', // Validación del nuevo campo
            'cantidad' => 'required|integer|min:1', // Añadido mínimo 1
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

    // Método para manejar la entrada de medicamentos
    public function recordEntry(Request $request, Medication $medication)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1' // Añadido mínimo 1
        ]);

        $medication->increment('cantidad', $request->cantidad);

        return redirect()->route('medications.index')->with('success', 'Entrada de medicamento registrada correctamente.');
    }

    // Método para manejar la salida de medicamentos
    public function recordExit(Request $request, Medication $medication)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1' // Añadido mínimo 1
        ]);

        if ($medication->cantidad >= $request->cantidad) {
            $medication->decrement('cantidad', $request->cantidad);
            return redirect()->route('medications.index')->with('success', 'Salida de medicamento registrada correctamente.');
        } else {
            return redirect()->route('medications.index')->with('error', 'No hay suficiente cantidad disponible.');
        }
    }

    public function sale(Request $request)
{
    $request->validate([
        'medication_id' => 'required|exists:medications,id',
        'cantidad' => 'required|integer|min:1',
    ]);

    $medication = Medication::find($request->medication_id);

    // Verificar si hay suficiente cantidad
    if ($medication->cantidad >= $request->cantidad) {
        $medication->cantidad -= $request->cantidad;
        $medication->save();

        return redirect()->route('medications.index')->with('success', 'Salida registrada correctamente.');
    }

    return redirect()->route('medications.index')->with('error', 'No hay suficiente cantidad disponible.');
}


    
}
