<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_analisis_id',
    ];

    protected $table = 'examenes';  


public function tipoAnalisis()
{
    return $this->belongsTo(TipoAnalisis::class, 'tipo_analisis_id');
}


    public function realizarExamenes()
    {
        return $this->hasMany(RealizarExamen::class);
    }
}