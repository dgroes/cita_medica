<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'blood_type_id',
        'allergies',
        'chronic_conditions',
        'surgical_history',
        'family_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_phone',
        'photo',
    ];


    //Relación uno a uno inversa con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación inversa con BloodType
    public function bloodType(){
        return $this->belongsTo(BloodType::class, 'blood_type_id');
    }
}
