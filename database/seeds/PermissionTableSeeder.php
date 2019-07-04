<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder

{

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    	$permissions = [
			'militares-menu',
    		'militares-add',
    		'militares-list',
    		'militares-edit',
			
			'veiculos-menu',
    		'veiculos-add',
    		'veiculos-list',
    		'veiculos-edit',

			'consultas-menu',
    		'consultas-aut',
    		'consultas-ped',

    		'cracha-aut',
    		'cracha-ped',
    		'cracha-vtr',

			'relatorios-menu',
    		'relatorios-aut',
    		'relatorios-hrs',
    		'relatorios-mil',

			'config-om-menu',
    		'config-om-add',
    		'config-om-edit',
    		'config-om-list',

			'config-usuario-menu',
    		'config-usuario-add',
    		'config-usuario-edit',
    		'config-usuario-list',

			'config-vtr-menu',
    		'config-vtr-add',
    		'config-vtr-edit',
    		'config-vtr-list',

    		'config-veiculos-menu',
    		'config-veiculos-tipo',
    		'config-veiculos-marca',
    		'config-veiculos-modelo',

    		'config-horarios',
    		'config-postos',
    		'config-trocar-cracha',
    	];

    	foreach ($permissions as $permission) {
    		Permission::create(['name' => $permission]);
    	}
    }
}