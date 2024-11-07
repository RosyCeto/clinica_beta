<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'vacuna_id', 
    ];

    protected $table = 'dosis';  

    public function vacuna()
    {
        return $this->belongsTo(Vacuna::class, 'vacuna_id');
    }
}