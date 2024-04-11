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
        'complaints',
        'diagnosis',
        'recommendations',
        'result_pdf',
        'closed'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user(): User
    {
        return User::find($this->user_id);
    }
}
