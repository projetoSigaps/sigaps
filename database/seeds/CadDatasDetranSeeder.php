<?php

use Illuminate\Database\Seeder;

class CadDatasDetranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'app/Seeders/cad_datas_detran.sql';
    	DB::unprepared(file_get_contents($path));
    	$this->command->info('cad_datas_detran table seeded!');
    }
}
