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
    public function ped(User $user)
    {
        return $user->hasPermissionTo('consultas-ped');
    }

    public function auto(User $user)
    {
        return $user->hasPermissionTo('consultas-aut');
    }
}
