<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class veiculosPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function veiculos_add(User $user)
    {
        return $user->hasPermissionTo('veiculos-add');
    }

    public function veiculos_list(User $user)
    {
        return $user->hasPermissionTo('veiculos-list');
    }

}
