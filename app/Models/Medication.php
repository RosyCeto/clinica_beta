<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsDate;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'codigo', 'cantidad', 'fecha_caducidad', 'fecha_ingreso'
    ];

    protected $dates = ['fecha_caducidad', 'fecha_ingreso'];

    protected $casts = [
        'fecha_caducidad' => 'date', 
        'fecha_ingreso' => 'date',
    ];
    
    public function setCantidadAttribute($value)
    {
        $this->attributes['cantidad'] = max(0, (int) $value);
    }

    public function getFormattedFechaCaducidadAttribute()
    {
        return $this->fecha_caducidad->format('d/m/Y');
    }

    public function scopeProximosACaducar($query)
    {
        return $query->where('fecha_caducidad', '<', now()->addMonth());
    }

    public function scopeBajoStock($query, $cantidad = 10)
    {
        return $query->where('cantidad', '<', $cantidad);
    }
}