<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = [
        'bib_number',
        'qr_token',
        'name',
        'community',
        'birth_date',
        'address',
        'phone',
        'emergency_contact',
        'blood_type',
        'registered_at',
        'cp1_at',
        'cp2_at',
        'finished_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registered_at' => 'datetime',
        'cp1_at' => 'datetime',
        'cp2_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function scanLogs(): HasMany
    {
        return $this->hasMany(ScanLog::class);
    }
}
