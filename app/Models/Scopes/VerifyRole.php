<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use Illuminate\Support\Facades\Auth;

// C66: Query Scopes
class VerifyRole implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::user()?->hasRole('Doctor')) {
            $builder->whereHas('doctor', function ($builder) {
                $builder->where('user_id', Auth::id());
            });
        }

        if (Auth::user()?->hasRole('Paciente')) {
            $builder->whereHas('patient', function ($builder) {
                $builder->where('user_id', Auth::id());
            });
        }
    }
}
