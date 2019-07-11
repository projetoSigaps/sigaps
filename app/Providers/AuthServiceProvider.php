<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;

use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_entrada_saida;
use App\Model\Sys\Cad_om;
use App\Model\Sys\Cad_viaturas;
use App\Model\Sys\Cad_tipo_automovel;
use App\Model\Sys\Cad_marca;
use App\Model\Sys\Cad_modelo;

use App\Policies\militarPolicy;
use App\Policies\veiculosPolicy;
use App\Policies\consultaPolicy;
use App\Policies\omPolicy;
use App\Policies\usuarioPolicy;
use App\Policies\viaturaPolicy;
use App\Policies\veiculoMarcaPolicy;
use App\Policies\veiculoModeloPolicy;
use App\Policies\veiculoTipoPolicy;


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
        Cad_viaturas::class => viaturaPolicy::class,
        Cad_tipo_automovel::class => veiculoTipoPolicy::class,
        Cad_marca::class => veiculoMarcaPolicy::class,
        Cad_modelo::class => veiculoModeloPolicy::class,
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
