<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class veiculoMarcaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function config_veiculos_marca(User $user)
    {
        return $user->hasPermissionTo('config-veiculos-marca');
    }
}
