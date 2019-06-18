<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('####### ATENÇÃO! #######');
        $this->command->info('- LOGO ABAIXO, SERÁ CRIADO O USUÁRIO SUPER-ADMIN DO SISTEMA');
        $this->command->info('- A SENHA INICIAL SERÁ O LOGIN');
        $this->command->info('########################');
        $name = $this->command->ask('# 1 - Digite o nome completo do usuário (Ex: Duque de Caxias)');
        $login = $this->command->ask('# 2 - Digite o login do usuário (Ex: duque)');
        $email = $this->command->ask('# 3 - Digite um endereço de e-mail para o usuário');

        DB::table('users')->insert([
            'name' => strtoupper($name),
            'login' => strtolower($login),
            'password' => bcrypt($login),
            'email' => strtolower($email),
            'om_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\User',
            'model_id' => 1
        ]);
        $this->command->info('####### USUÁRIO CRIADO COM SUCESSO! #######');
    }
}
