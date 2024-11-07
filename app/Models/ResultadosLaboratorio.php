<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadosLaboratorio extends Model
{
    use HasFactory;

    protected $table = 'resultados_laboratorio';

    protected $fillable = [
        'realizar_examen_id',
        'archivo',  
        'comentarios',
        'fecha_registro',
        'estado',
    ];

    public function realizarExamen()
    {
        return $this->belongsTo(RealizarExamen::class, 'realizar_examen_id');
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }
}