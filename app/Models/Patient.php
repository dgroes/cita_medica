<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    protected $fillable = [
        'user_id',
        'blod_type_id',
        'allergies',
        'chronic_conditions',
        'surgical_history',
        'family_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_phone',
        'date_of_birth',
        'photo',
    ];


    //Relación uno a uno inversa con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación inversa con BloodType
    public function bloodType(){
        return $this->belongsTo(BloodType::class, 'blod_type_id');
    }
}
