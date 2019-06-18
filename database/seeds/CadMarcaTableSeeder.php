<?php

use Illuminate\Database\Seeder;

class CadMarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$path = 'app/Seeders/cad_marca.sql';
    	DB::unprepared(file_get_contents($path));
    	$this->command->info('cad_marca table seeded!');
    }
}
