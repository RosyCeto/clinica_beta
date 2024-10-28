<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;


    // Relación inversa: cada laboratorio pertenece a un paciente
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
