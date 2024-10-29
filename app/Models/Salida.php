<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    protected $table = 'salidas'; // Asegúrate de que el nombre de la tabla sea correcto

    protected $fillable = [
        'medication_id',
        'cantidad',
        'fecha_salida',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
