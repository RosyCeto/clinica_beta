<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmunizacion extends Model
{
    use HasFactory;

    protected $table = 'inmunizaciones';

    
    protected $fillable = ['paciente_id', 'vacuna_id', 'dosis_id', 'fecha_vacunacion'];

   
    protected $casts = [
        'fecha_vacunacion' => 'date', 
    ];


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