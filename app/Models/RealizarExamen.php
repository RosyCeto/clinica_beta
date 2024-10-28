<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealizarExamen extends Model
{
    use HasFactory;

    // Especifica el nombre correcto de la tabla
    protected $table = 'realizar_examenes';

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'examen_id',
        'medico_id',
        'paciente_id',
        'fecha',
        'status',
        'usuario_id' // Asegúrate de incluir este campo también
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

     // Relación con los resultados de laboratorio
     public function resultadoLaboratorio()
     {
         return $this->hasOne(ResultadosLaboratorio::class, 'realizar_examen_id');
     }

     public function tipoAnalisis()
{
    return $this->belongsTo(TipoAnalisis::class, 'tipo_analisis_id'); // Asegúrate de que el nombre de la columna sea correcto
}



     

}