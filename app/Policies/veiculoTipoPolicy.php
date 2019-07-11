<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class veiculoTipoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function config_veiculos_tipo(User $user)
    {
        return $user->hasPermissionTo('config-veiculos-tipo');
    }
}
