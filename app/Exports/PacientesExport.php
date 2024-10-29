<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PacientesExport implements FromCollection, WithHeadings
{
    // Obtiene todos los pacientes
    public function collection()
    {
        return Patient::all();
    }

    // Define los encabezados de las columnas en el archivo de Excel
    public function headings(): array
    {
        return [
            'ID',
            'CUI',                     // Código Único de Identificación
            'Número de Expediente',    // Número de expediente
            'Primer Nombre',           // Primer nombre
            'Segundo Nombre',          // Segundo nombre
            'Primer Apellido',         // Primer apellido
            'Segundo Apellido',        // Segundo apellido
            'Apellido de Casada',      // Apellido de casada
            'Género',                  // Género
            'Etnia',                   // Etnia
            'Fecha de Nacimiento',     // Fecha de nacimiento
            'Edad',                    // Edad
            'Discapacidad',            // Discapacidad
            'Escolaridad',             // Escolaridad
            'Profesión',               // Profesión
            'Teléfono',                // Teléfono
            'Dirección',               // Dirección
            // Agrega más encabezados según tus necesidades
        ];
    }
}
