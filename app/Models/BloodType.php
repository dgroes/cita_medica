<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
/* C36: Relaciones (en modelos) */
{
    //Relación uno a muchos con Patient
    public function patients()
    {
        return $this->hasMany(Patient::class, 'blod_type_id');
    }
}
