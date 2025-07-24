<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'speciality_id',
        'medical_license_number',
        'phone',
        'biography',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    /* C44: Gestión de horarios */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
