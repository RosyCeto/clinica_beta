<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_analisis_id', // Asegúrate de que coincide con la columna en la tabla
    ];

    protected $table = 'examenes';  // Asegúrate de que apunta a la tabla correcta

    // Relación con TipoAnalisis

public function tipoAnalisis()
{
    return $this->belongsTo(TipoAnalisis::class, 'tipo_analisis_id');
}


    public function realizarExamenes()
    {
        return $this->hasMany(RealizarExamen::class);
    }
}