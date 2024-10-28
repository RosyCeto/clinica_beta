<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmunizacion extends Model
{
    use HasFactory;

    protected $table = 'inmunizaciones';

    // Define los campos que se pueden asignar masivamente
    protected $fillable = ['paciente_id', 'vacuna_id', 'dosis_id', 'fecha_vacunacion'];

    // Asegurarse de que 'fecha_vacunacion' se trate como una fecha
    protected $casts = [
        'fecha_vacunacion' => 'date', // Esto convierte automáticamente el string a un objeto Carbon
    ];


    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Patient::class);
    }

    public function vacuna()
    {
        return $this->belongsTo(Vacuna::class);
    }

    public function dosis()
    {
        return $this->belongsTo(Dosis::class);
    }
}
