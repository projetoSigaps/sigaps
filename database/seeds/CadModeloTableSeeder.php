<?php

use Illuminate\Database\Seeder;

class CadModeloTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$path = 'app/Seeders/cad_modelo.sql';
    	DB::unprepared(file_get_contents($path));
    	$this->command->info('cad_modelo table seeded!');
    }
}
