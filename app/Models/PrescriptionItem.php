<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrescriptionItem extends Model
{

    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'dosage',
        'duration',
        'frequency',
        'instructions',
    ];

    protected $casts = [];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
