<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Patient;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;



class MedicalHistoryController extends Controller
{


    public function index(Request $request)
{
    $search = $request->input('search');

    // Utiliza una consulta donde manejes los espacios
    $patients = Patient::with('medicalHistories')
        ->where(function ($query) use ($search) {
            $query->where('cui', 'like', "%{$search}%")
                ->orWhere('nexpedientes', 'like', "%{$search}%")
                ->orWhere(DB::raw("CONCAT_WS(' ', primer_nombre, segundo_nombre, primer_apellido, segundo_apellido)"), 'LIKE', "%{$search}%")
                ->orWhereHas('medicalHistories', function ($query) use ($search) {
                    $query->whereDate('created_at', $search);
                });
        })
        ->paginate(10); // Asegúrate de que la paginación esté activada

    if ($request->ajax()) {
        return view('medical_histories.partials.search_results', compact('patients'))->render();
    }

    return view('medical_histories.index', compact('patients'));
}




    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        return view('medical_histories.create', compact('patient'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'type_consult' => 'required|string',
        'consultation_reason' => 'required|string',
        'current_illness_history' => 'required|string',
        'personal_history' => 'required|string',
        'family_history' => 'required|string',
        'habits_history' => 'required|string',
        'allergies' => 'required|string',
        'vital_signs' => 'required|string',
        'weight' => 'required|numeric',
        'height' => 'required|numeric',
        'diagnosis_treatment' => 'required|string',
        'comments' => 'required|string',
    ]);

    // Guardar el historial clínico
    MedicalHistory::create($validatedData);

    return redirect()->route('medical_histories.index')->with('success', 'Historial clínico guardado exitosamente.');
}


    public function edit($id)
{
    // Buscar el historial médico por su ID
    $medicalHistory = MedicalHistory::findOrFail($id);
    
    // Obtener el paciente asociado a ese historial médico
    $patient = $medicalHistory->patient; // Asumiendo que la relación está definida en el modelo MedicalHistory
    
    return view('medical_histories.edit', compact('medicalHistory', 'patient'));
}


public function update(Request $request, $id)
{
    // Validate the fields
    $validated = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'type_consult' => 'required|in:primera consulta,consulta general',
        'consultation_reason' => 'required|string',
        'current_illness_history' => 'required|string',
        'personal_history' => 'required|string',
        'family_history' => 'required|string',
        'habits_history' => 'required|string',
        'allergies' => 'required|string',
        'vital_signs' => 'required|string',
        'weight' => 'required|numeric',
        'height' => 'required|numeric',
        'diagnosis_treatment' => 'required|string',
        'comments' => 'required|string',
    ]);

    // Actualiza el historial médico
    $medicalHistory = MedicalHistory::findOrFail($id);
    $medicalHistory->update($validated);

    // Redirigir con mensaje de éxito
    return redirect()->route('medical_histories.index')->with('success', 'Historial clínico actualizado exitosamente.');
}


    public function destroy($id)
    {
        // Elimina un historial médico existente
        $medicalHistory = MedicalHistory::findOrFail($id);
        $medicalHistory->delete();

        return redirect()->route('medical_histories.index')->with('success', 'Historial médico eliminado correctamente.');
    }

    public function showPdf($id) {
        // Obtener el historial médico específico por ID
        $medicalHistory = MedicalHistory::findOrFail($id);
    
        // Encontrar el paciente asociado al historial médico
        $patient = $medicalHistory->patient;
    
        // Cargar la vista para el PDF
        $pdf = Pdf::loadView('medical_histories.pdf', [
            'patient' => $patient,
            'medicalHistory' => $medicalHistory,
        ]);
    
        // Retornar el PDF
        return $pdf->download('historial_medico_' . $patient->full_name . '.pdf');
    }
    
}