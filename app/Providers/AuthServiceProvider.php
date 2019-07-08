<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use App\Model\Sys\Cad_entrada_saida;
use App\Policies\militarPolicy;
use App\Policies\veiculosPolicy;
use App\Policies\consultaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Cad_militar::class => militarPolicy::class,
        Cad_automovel::class => veiculosPolicy::class,
        Cad_entrada_saida::class => consultaPolicy::class
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
