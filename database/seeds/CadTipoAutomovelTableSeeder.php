<?php

use Illuminate\Database\Seeder;

class CadTipoAutomovelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$path = 'app/Seeders/cad_tipo_automovel.sql';
    	DB::unprepared(file_get_contents($path));
    	$this->command->info('cad_tipo_automovel table seeded!');
    }
}
