<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'appointment_date',
        'appointment_time',
        'diagnosis',
        'symptoms',
        'notes',
        'blood_pressure',
        'temperature',
        'heart_rate',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
