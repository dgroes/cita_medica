<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* C55: Consultation */

class Consultation extends Model
{
    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'treatment',
        'notes',
        'prescriptions',
    ];

    protected $casts = [
        'prescriptions' => 'json',
    ];

    //Relación inversa con Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
