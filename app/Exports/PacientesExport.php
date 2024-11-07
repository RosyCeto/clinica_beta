<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PacientesExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Patient::all();
    }


    public function headings(): array
    {
        return [
            'ID',
            'CUI',                    
            'Número de Expediente',   
            'Primer Nombre',          
            'Segundo Nombre',        
            'Primer Apellido',        
            'Segundo Apellido',      
            'Apellido de Casada',     
            'Género',                  
            'Etnia',                 
            'Fecha de Nacimiento',     
            'Edad',                
            'Discapacidad',          
            'Escolaridad',          
            'Profesión',          
            'Teléfono',               
            'Dirección',            
        ];
    }
}