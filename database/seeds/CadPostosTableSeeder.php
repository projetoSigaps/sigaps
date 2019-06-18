<?php

use Illuminate\Database\Seeder;

class CadPostoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$path = 'app/Seeders/cad_posto.sql';
    	DB::unprepared(file_get_contents($path));
    	$this->command->info('cad_posto table seeded!');
    }
}
