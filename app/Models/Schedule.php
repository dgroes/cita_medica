<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/* C44: Gestión de horarios */

class Schedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /* Casteo de 'day_of_week', start_time' y 'end_time '*/
    /*
        Pasando de "2025-07-23T12:00:00.000000Z" a "2025-07-23 12:00:00"
    */
    protected $casts = [
        'day_of_week' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
