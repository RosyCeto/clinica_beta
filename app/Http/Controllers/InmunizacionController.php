<?php

namespace App\Http\Controllers;

use App\Models\Inmunizacion;
use App\Models\Vacuna;
use App\Models\Dosis;
use App\Models\Patient;
use Illuminate\Http\Request;

class InmunizacionController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // Filtra por búsqueda y paginación
    $inmunizaciones = Inmunizacion::with(['paciente', 'vacuna', 'dosis'])
        ->when($search, function ($query) use ($search) {
            $query->where('id', 'like', "%{$search}%")
                  ->orWhereHas('paciente', function ($query) use ($search) {
                      $query->where('primer_nombre', 'like', "%{$search}%")
                            ->orWhere('primer_apellido', 'like', "%{$search}%");
                  })
                  ->orWhereHas('vacuna', function ($query) use ($search) {
                      $query->where('nombre', 'like', "%{$search}%");
                  });
        })
        ->paginate(10); // Cambia a 10 resultados por página

        

    return view('inmunizaciones.index', compact('inmunizaciones'));
}

    public function create()
    {
        $pacientes = Patient::paginate(10);
        $vacunas = Vacuna::all();
        return view('inmunizaciones.create', compact('pacientes', 'vacunas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:patients,id',
            'vacuna_id' => 'required|exists:vacunas,id',
            'dosis_id' => 'required|exists:dosis,id',
            'fecha_vacunacion' => 'required|date',
        ]);

        Inmunizacion::create($request->all());

        return redirect()->route('inmunizaciones.index')->with('success', 'Inmunización registrada con éxito');
    }

    public function mostrarDosis(Request $request)
    {
        $request->validate(['vacuna_id' => 'required|exists:vacunas,id']);
        $dosis = Dosis::where('vacuna_id', $request->vacuna_id)->get();
        return response()->json($dosis);
    }

    public function edit($id)
    {
        $inmunizacion = Inmunizacion::findOrFail($id);
        $pacientes = Patient::paginate(10);
        $vacunas = Vacuna::all();
        $dosis = Dosis::where('vacuna_id', $inmunizacion->vacuna_id)->get();
        return view('inmunizaciones.edit', compact('inmunizacion', 'pacientes', 'vacunas', 'dosis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|exists:patients,id',
            'vacuna_id' => 'required|exists:vacunas,id',
            'dosis_id' => 'required|exists:dosis,id',
            'fecha_vacunacion' => 'required|date',
        ]);

        $inmunizacion = Inmunizacion::findOrFail($id);
        $inmunizacion->update($request->all());

        return redirect()->route('inmunizaciones.index')->with('success', 'Inmunización actualizada con éxito.');
    }
}
