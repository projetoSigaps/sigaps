<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class viaturaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function config_vtr_add(User $user)
    {
        return $user->hasPermissionTo('config-vtr-add');
    }

    public function config_vtr_list(User $user)
    {
        return $user->hasPermissionTo('config-vtr-list');
    }
}
