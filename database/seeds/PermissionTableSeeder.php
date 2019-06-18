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
    		'militares-add',
    		'militares-list',
    		'militares-edit',
    		
    		'veiculos-add',
    		'veiculos-list',
    		'veiculos-edit',

    		'consultas-aut',
    		'consultas-ped',

    		'cracha-aut',
    		'cracha-ped',
    		'cracha-vtr',

    		'relatorios-aut',
    		'relatorios-hrs',
    		'relatorios-mil',

    		'config-om-add',
    		'config-om-edit',
    		'config-om-list',

    		'config-vtr-add',
    		'config-vtr-edit',
    		'config-vtr-list',

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