<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimetableLog extends Model
{
    protected $fillable = [
        'year',
        'month',
        'doctor_id',
        'admin_id'
    ];
}
