<?php

namespace App\Models;

use App\Enums\AppointmentEnum;
use App\Models\Scopes\VerifyRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

// C66: Query Scopes
#[ScopedBy([VerifyRole::class])]

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'reason',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => AppointmentEnum::class,
    ];


    // C59: Calendario
    //Accesores
    public function start(): Attribute
    {
        return Attribute::make(
            get: function () {
                $date = $this->date->format('Y-m-d');
                $time = $this->start_time->format('H:i:s');

                return Carbon::parse("{$date} {$time}");
            }
        );
    }

    //Accesores
    public function end(): Attribute
    {
        return Attribute::make(
            get: function () {
                $date = $this->date->format('Y-m-d');
                $time = $this->end_time->format('H:i:s');

                return Carbon::parse("{$date} {$time}");
            }
        );
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // C55: Consultation
    // --> Una consulta por cita / Relación uno a uno
    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }
}
