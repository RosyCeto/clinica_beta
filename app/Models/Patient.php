<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;


    protected $table = 'patients';

    protected $fillable = [
        'cui',
        'nexpedientes',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'apellido_casada',
        'gender',
        'etnia',
        'fecha_nacimiento',
        'edad',
        'discapacidad',
        'escolaridad',
        'profesion',
        'telefono',
        'direccion',
    ];


    // Relación con el modelo MedicalHistory
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }

    // Relación con el modelo Laboratory
    public function laboratories()
    {
        return $this->hasMany(Laboratory::class);
    }

   
    public function getFullNameAttribute()
    {
        return trim("{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}");
    }


    
}
