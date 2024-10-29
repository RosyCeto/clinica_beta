<?php

namespace App\Exports;

use App\Models\MedicalHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistorialClinicoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Obtener todos los historiales clínicos y añadir el nombre del paciente
        return MedicalHistory::with('patient')->get()->map(function ($historial) {
            return [
                'nombre_paciente' => $historial->patient->primer_nombre, // Primer nombre del paciente
                'apellido_paciente' => $historial->patient->primer_apellido, // Primer apellido del paciente
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
            'Nombre del Paciente', // 'nombre_paciente'
            'Apellido del Paciente', // 'apellido_paciente'
            'Tipo de Consulta', // 'tipo_consulta'
            'Motivo de Consulta', // 'motivo_consulta'
            'Historia de Enfermedad Actual', // 'historia_enfermedad_actual'
            'Antecedentes Personales', // 'antecedentes_personales'
            'Antecedentes Familiares', // 'antecedentes_familiares'
            'Historia de Hábitos', // 'historia_habitos'
            'Alergias', // 'alergias'
            'Examen Físico', // 'examen_fisico'
            'Signos Vitales', // 'signos_vitales'
            'Peso', // 'peso'
            'Altura', // 'altura'
            'Diagnóstico y Tratamiento', // 'diagnostico_tratamiento'
            'Comentarios', // 'comentarios'
        ];
    }
}
