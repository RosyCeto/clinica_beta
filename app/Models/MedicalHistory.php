<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;


    protected $fillable = [
        'patient_id',
        'type_consult',
        'consultation_reason', 
        'current_illness_history', 
        'personal_history',
        'family_history',
        'habits_history',
        'allergies',
        'physical_exam',
        'vital_signs',
        'weight',
        'height',
        'diagnosis_treatment',
        'comments',
    ];

    public $timestamps = true; // This is enabled by default

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function getFullNameAttribute()
{
    return "{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}";
}
public function medicalHistory()
{
    return $this->hasMany(MedicalHistory::class);
}



}