<?php

namespace App\Exports;

use App\Models\Medication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductosFarmaciaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Medication::all(); // Obtén todos los productos de farmacia
    }

    public function headings(): array
    {
        return [
            'ID',
            'nombre', 
            'descripcion',
            'codigo',
            'cantidad',
            'fecha_caducidad' 
        ];
    }
}
