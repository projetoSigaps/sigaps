<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class usuarioPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function config_usuario_add(User $user)
    {
        return $user->hasPermissionTo('config-usuario-add');
    }

    public function config_usuario_edit(User $user)
    {
        return $user->hasPermissionTo('config-usuario-edit');
    }

    public function config_usuario_list(User $user)
    {
        return $user->hasPermissionTo('config-usuario-list');
    }
}
