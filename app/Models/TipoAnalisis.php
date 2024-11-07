<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnalisis extends Model
{
    use HasFactory;

    protected $table = 'tipos_analisis'; 
    protected $fillable = ['nombre']; 

   
    public function examenes()
    {
        return $this->hasMany(Examen::class, 'tipo_analisis_id');
    }
}