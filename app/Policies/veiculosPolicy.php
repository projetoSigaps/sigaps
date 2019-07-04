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
    public function create(User $user)
    {
        return $user->hasPermissionTo('veiculos-add');
    }

    public function list(User $user)
    {
        return $user->hasPermissionTo('veiculos-list');
    }
}
