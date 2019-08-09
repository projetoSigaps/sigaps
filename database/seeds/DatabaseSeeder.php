<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CadPostoTableSeeder::class);
        $this->call(CadModeloTableSeeder::class);
        $this->call(CadMarcaTableSeeder::class);
        $this->call(CadTipoAutomovelTableSeeder::class);
        $this->call(CadOperacaoTableSeeder::class);
        $this->call(CadOmTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CadDatasDetranSeeder::class);
    }
}
