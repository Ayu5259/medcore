<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class VisitReport extends Model
{
    /** @use HasFactory<\Database\Factories\VisitReportFactory> */
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'symptoms',
        'notes',
        'blood_pressure',
        'temperature',
        'heart_rate',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
