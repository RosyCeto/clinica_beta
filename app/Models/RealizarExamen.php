<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealizarExamen extends Model
{
    use HasFactory;

    protected $table = 'realizar_examenes';

    
    protected $fillable = [
        'examen_id',
        'medico_id',
        'paciente_id',
        'fecha',
        'status',
        'usuario_id' 
    ];

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Patient::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

  
     public function resultadoLaboratorio()
     {
         return $this->hasOne(ResultadosLaboratorio::class, 'realizar_examen_id');
     }

     public function tipoAnalisis()
    {
    return $this->belongsTo(TipoAnalisis::class, 'tipo_analisis_id'); 
    }
}