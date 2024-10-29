<?php

namespace App\Exports;

use App\Models\Salida;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalidasMedicamentosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Salida::with('medication')->get(); // Asegúrate de incluir la relación
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Medicamento',
            'Código Medicamento',
            'Cantidad',
            'Fecha de Salida',
        ];
    }

    public function map($salida): array
    {
        return [
            $salida->id,
            $salida->medication->nombre ?? 'N/A', // Mostrar nombre del medicamento
            $salida->medication->codigo ?? 'N/A', // Mostrar código del medicamento
            $salida->cantidad,
            $salida->fecha_salida->format('d-m-Y'), // Formato de fecha
        ];
    }
}
