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
   
        $citas = Cita::paginate(10); 
        $citasPendientesCount = Cita::where('status', 'pendiente')->count();
        return view('citas.index', compact('citas', 'citasPendientesCount')); 
    }

public function create()
{
    $pacientes = Patient::paginate(10);
    $medicos = Medico::paginate(10);
    return view('citas.create', compact('pacientes', 'medicos'));
}

public function store(Request $request)
    {

        $request->validate([
            'paciente_id' => 'required|exists:patients,id',
            'medico_id' => 'required|exists:medicos,id',
            'fecha' => 'required|date',
        ]);

        Cita::create([
            'paciente_id' => $request->paciente_id,
            'medico_id' => $request->medico_id,
            'fecha' => $request->fecha,
            'status' => 'pendiente', 
        ]);
        
        return redirect()->route('citas.index')->with('success', 'Cita agendada correctamente.');
    }

    public function cancel($id)
    {
        $cita = Cita::find($id);

        if ($cita) {
            
            $cita->status = 'cancelada';
            $cita->save();

            return redirect()->route('citas.index')->with('success', 'Cita cancelada exitosamente.');
        }
        return redirect()->route('citas.index')->with('error', 'Cita no encontrada.');
    }

    public function getNotificaciones()
    {
        $hoy = Carbon::now();
        $notificaciones = Cita::where('fecha', '>=', $hoy)->get();
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