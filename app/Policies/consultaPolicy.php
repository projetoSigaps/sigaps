<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class consultaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function consultas_ped(User $user)
    {
        return $user->hasPermissionTo('consultas-ped');
    }

    public function consultas_aut(User $user)
    {
        return $user->hasPermissionTo('consultas-aut');
    }

    public function config_horarios(User $user)
    {
        return $user->hasPermissionTo('config-horarios');
    }
}
