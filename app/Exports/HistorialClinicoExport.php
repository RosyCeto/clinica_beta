<?php

namespace App\Exports;

use App\Models\MedicalHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistorialClinicoExport implements FromCollection, WithHeadings
{
    public function collection()
    {

        return MedicalHistory::with('patient')->get()->map(function ($historial) {
            return [
                'nombre_paciente' => $historial->patient->primer_nombre, 
                'apellido_paciente' => $historial->patient->primer_apellido, 
                'tipo_consulta' => $historial->type_consult,
                'motivo_consulta' => $historial->consultation_reason,
                'historia_enfermedad_actual' => $historial->current_illness_history,
                'antecedentes_personales' => $historial->personal_history,
                'antecedentes_familiares' => $historial->family_history,
                'historia_habitos' => $historial->habits_history,
                'alergias' => $historial->allergies,
                'examen_fisico' => $historial->physical_exam,
                'signos_vitales' => $historial->vital_signs,
                'peso' => $historial->weight,
                'altura' => $historial->height,
                'diagnostico_tratamiento' => $historial->diagnosis_treatment,
                'comentarios' => $historial->comments,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre del Paciente', 
            'Apellido del Paciente', 
            'Tipo de Consulta', 
            'Motivo de Consulta', 
            'Historia de Enfermedad Actual', 
            'Antecedentes Personales', 
            'Antecedentes Familiares', 
            'Historia de Hábitos', 
            'Alergias', 
            'Examen Físico', 
            'Signos Vitales', 
            'Peso', 
            'Altura', 
            'Diagnóstico y Tratamiento', 
            'Comentarios', 
        ];
    }
}