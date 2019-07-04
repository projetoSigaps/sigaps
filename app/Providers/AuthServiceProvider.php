<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\Sys\Cad_militar;
use App\Model\Sys\Cad_automovel;
use App\Policies\militarPolicy;
use App\Policies\veiculosPolicy;

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
        Cad_automovel::class => veiculosPolicy::class
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
