<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Patient;
use App\Models\Medico;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; 

class CitaController extends Controller
{
    public function index()
    {
   
        $citas = Cita::paginate(10); // Esto devuelve una instancia de LengthAwarePaginator
        $citasPendientesCount = Cita::where('status', 'pendiente')->count();
        return view('citas.index', compact('citas', 'citasPendientesCount')); // Agregamos 'citasPendientesCount' a la vista
    }



public function create()
{
    $pacientes = Patient::paginate(10);
    $medicos = Medico::paginate(10);
    return view('citas.create', compact('pacientes', 'medicos'));
}


public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'paciente_id' => 'required|exists:patients,id',
            'medico_id' => 'required|exists:medicos,id',
            'fecha' => 'required|date',
        ]);

        // Crear la cita
        Cita::create([
            'paciente_id' => $request->paciente_id,
            'medico_id' => $request->medico_id,
            'fecha' => $request->fecha,
            'status' => 'pendiente', // Estado predeterminado
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('citas.index')->with('success', 'Cita agendada correctamente.');
    }



    public function cancel($id)
    {
        $cita = Cita::find($id);

        if ($cita) {
            // Cambiar el estado a cancelado
            $cita->status = 'cancelada';
            $cita->save();

            return redirect()->route('citas.index')->with('success', 'Cita cancelada exitosamente.');
        }

        return redirect()->route('citas.index')->with('error', 'Cita no encontrada.');
    }

    public function getNotificaciones()
    {
        $hoy = Carbon::now();
        $notificaciones = Cita::where('fecha', '>=', $hoy)->get(); // Asegúrate de que el campo sea correcto
        return view('citas.index', compact('notificaciones'));
    }


    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        return view('citas.edit', compact('cita'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'fecha' => 'required|date',
        'status' => 'required|string',
    ]);

    $cita = Cita::findOrFail($id);
    $cita->fecha = $request->fecha;
    $cita->status = $request->status;
    $cita->save();

    return redirect()->route('citas.index')->with('success', 'Cita reprogramada con éxito.');
}



}
