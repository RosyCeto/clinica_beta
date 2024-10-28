<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnalisis extends Model
{
    use HasFactory;

    protected $table = 'tipos_analisis'; // Nombre correcto de la tabla
    protected $fillable = ['nombre']; // Los campos que se pueden llenar

    // Relación: un tipo de análisis tiene muchos exámenes
    public function examenes()
    {
        return $this->hasMany(Examen::class, 'tipo_analisis_id');
    }
}
