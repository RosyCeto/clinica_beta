<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsDate;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'codigo', 'cantidad', 'fecha_caducidad' // Añadido el campo 'codigo'
    ];

    protected $dates = ['fecha_caducidad'];

    protected $casts = [
        'fecha_caducidad' => 'date', // Esto convierte la fecha a Carbon
    ];
    
    // Mutador para asegurar que la cantidad nunca sea negativa
    public function setCantidadAttribute($value)
    {
        $this->attributes['cantidad'] = max(0, (int) $value);
    }

    // Accesor para formatear la fecha de caducidad
    public function getFormattedFechaCaducidadAttribute()
    {
        return $this->fecha_caducidad->format('d/m/Y');
    }

    // Scope para medicamentos próximos a caducar
    public function scopeProximosACaducar($query)
    {
        return $query->where('fecha_caducidad', '<', now()->addMonth());
    }

    // Scope para medicamentos bajos en stock
    public function scopeBajoStock($query, $cantidad = 10)
    {
        return $query->where('cantidad', '<', $cantidad);
    }
}
