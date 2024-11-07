<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'fecha',
        'status',
    ];

    public function paciente()
{
    return $this->belongsTo(Patient::class, 'paciente_id');
}

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}