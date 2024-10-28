<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'vacuna_id', // Asegúrate de que coincide con la columna en la tabla
    ];

    protected $table = 'dosis';  // Asegúrate de que apunta a la tabla correcta

    // Relación con Vacuna
    public function vacuna()
    {
        return $this->belongsTo(Vacuna::class, 'vacuna_id');
    }
}
