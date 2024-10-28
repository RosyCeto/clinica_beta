<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function dosis()
    {
        return $this->hasMany(Dosis::class);
    }

    public function inmunizaciones()
    {
        return $this->hasMany(Inmunizacion::class);
    }
}