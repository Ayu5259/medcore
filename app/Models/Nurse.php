<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nurse extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'employee_number',
        'years_of_experience',
        'nursing_license_number',
        'employment_date',
        'shift',
    ];

    protected $casts = [
        'employment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
