<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_entrada_saida;
use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_viaturas;

use App\Policies\militarPolicy;
use App\Policies\veiculosPolicy;
use App\Policies\consultaPolicy;
use App\Policies\omPolicy;
use App\Policies\usuarioPolicy;
use App\Policies\viaturaPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Cad_automovel::class => veiculosPolicy::class,
        Cad_militar::class => militarPolicy::class,
        Cad_entrada_saida::class => consultaPolicy::class,
        Cad_om::class => omPolicy::class,
        User::class => usuarioPolicy::class,
        Cad_viaturas::class => viaturaPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()

    {
        $this->registerPolicies();
    }
}
