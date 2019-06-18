<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleTableSeeder extends Seeder

{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    	$roles = [
    		'super-admin',
    		'administrador',
    		'operador',
    		'registrador',
    	];

    	foreach ($roles as $role) {

            #rhp == Role has Permission#
    		$rhp = Role::create(['name' => $role]);

            switch ($role) {
                case 'super-admin':
                
                $rhp->givePermissionTo('militares-add');
                $rhp->givePermissionTo('militares-list');
                $rhp->givePermissionTo('militares-edit');

                $rhp->givePermissionTo('veiculos-add');
                $rhp->givePermissionTo('veiculos-list');
                $rhp->givePermissionTo('veiculos-edit');
                $rhp->givePermissionTo('consultas-aut');
                $rhp->givePermissionTo('consultas-ped');

                $rhp->givePermissionTo('cracha-aut');
                $rhp->givePermissionTo('cracha-ped');
                $rhp->givePermissionTo('cracha-vtr');

                $rhp->givePermissionTo('relatorios-aut');
                $rhp->givePermissionTo('relatorios-hrs');
                $rhp->givePermissionTo('relatorios-mil');

                $rhp->givePermissionTo('config-om-add');
                $rhp->givePermissionTo('config-om-edit');
                $rhp->givePermissionTo('config-om-list');

                $rhp->givePermissionTo('config-vtr-add');
                $rhp->givePermissionTo('config-vtr-edit');
                $rhp->givePermissionTo('config-vtr-list');

                $rhp->givePermissionTo('config-veiculos-tipo');
                $rhp->givePermissionTo('config-veiculos-marca');
                $rhp->givePermissionTo('config-veiculos-modelo');

                $rhp->givePermissionTo('config-horarios');
                $rhp->givePermissionTo('config-postos');
                $rhp->givePermissionTo('config-trocar-cracha');

                break;

                case 'administrador':

                $rhp->givePermissionTo('militares-add');
                $rhp->givePermissionTo('militares-list');
                $rhp->givePermissionTo('militares-edit');

                $rhp->givePermissionTo('veiculos-add');
                $rhp->givePermissionTo('veiculos-list');
                $rhp->givePermissionTo('veiculos-edit');

                $rhp->givePermissionTo('consultas-aut');
                $rhp->givePermissionTo('consultas-ped');

                $rhp->givePermissionTo('cracha-aut');
                $rhp->givePermissionTo('cracha-ped');
                $rhp->givePermissionTo('cracha-vtr');

                $rhp->givePermissionTo('relatorios-aut');
                $rhp->givePermissionTo('relatorios-hrs');
                $rhp->givePermissionTo('relatorios-mil');

                $rhp->givePermissionTo('config-vtr-add');
                $rhp->givePermissionTo('config-vtr-edit');
                $rhp->givePermissionTo('config-vtr-list');

                $rhp->givePermissionTo('config-horarios');
                $rhp->givePermissionTo('config-trocar-cracha');

                break;


                case 'operador':

                $rhp->givePermissionTo('militares-add');
                $rhp->givePermissionTo('militares-list');
                $rhp->givePermissionTo('militares-edit');

                $rhp->givePermissionTo('veiculos-add');
                $rhp->givePermissionTo('veiculos-list');
                $rhp->givePermissionTo('veiculos-edit');

                $rhp->givePermissionTo('relatorios-aut');
                $rhp->givePermissionTo('relatorios-mil');

                break;

                case 'registrador':

                $rhp->givePermissionTo('config-horarios');

                break;

                default:
                # code...
                break;
            }

        }
    }
}