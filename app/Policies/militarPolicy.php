<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class militarPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->hasPermissionTo('militares-add');
    }

    public function list(User $user)
    {
        return $user->hasPermissionTo('militares-list');
    }

    public function edit(User $user, $militar)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        } elseif ($user->hasAnyRole(['administrador', 'operador'])) {
            return $user->om_id == $militar->om_id;
        } else {
            return false;
        }
    }

    public function downloadPdf(User $user, $militar)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        if ($user->hasRole('registrador')) {
            return false;
        }
        if ($user->om_id == $militar->om_id) {
            return true;
        }
    }
}
