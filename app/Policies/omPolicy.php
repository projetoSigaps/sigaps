<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class omPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function config_om_add(User $user)
    {
        return $user->hasPermissionTo('config-om-add');
    }

    public function config_om_edit(User $user)
    {
        return $user->hasPermissionTo('config-om-edit');
    }

    public function config_om_list(User $user)
    {
        return $user->hasPermissionTo('config-om-list');
    }
}
