<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\Medication;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    public function create()
    {
        $medications = Medication::all(); 
        return view('salidas.create', compact('medications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medication_id' => 'required|exists:medications,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_salida' => 'required|date',
        ]);

        $medication = Medication::find($request->medication_id);
        if ($medication->cantidad < $request->cantidad) {
            return back()->with('error', 'No hay suficiente cantidad disponible.');
        }

        Salida::create([
            'medication_id' => $request->medication_id,
            'cantidad' => $request->cantidad,
            'fecha_salida' => $request->fecha_salida,
        ]);

        $medication->cantidad -= $request->cantidad;
        $medication->save();

        return redirect()->route('medications.index')->with('success', 'Salida registrada correctamente.');
    }
}