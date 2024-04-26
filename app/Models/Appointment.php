<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id',
        'user_id',
        'date',
        'duration',
        'complaints',
        'diagnosis',
        'recommendations',
        'closed',
        'busy'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user(): User|null
    {
        return User::find($this->user_id);
    }
}
