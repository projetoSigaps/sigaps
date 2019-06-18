<?php

use Illuminate\Database\Seeder;
use App\User;

class UpdateUsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$usuarios = User::all();
    	foreach ($usuarios as $value) {
    		$this->command->info('-----------');
    		$this->command->info('ID: '.$value->id);
    		$this->command->info('LOGIN: '.$value->login);
    		$this->command->info('EMAIL: '.$value->email);
    		$this->command->info('-----------');
    	}

    	$id_user = $this->command->ask('# INFORME O ID DO USUÁRIO QUE DESEJA ATUALIZAR');

    	$usuario = User::findOrFail($id_user);

    	$this->command->info('###### USUÁRIO #######');
    	$this->command->info('ID: '.$usuario->id);
    	$this->command->info('LOGIN: '.$usuario->login);
    	$this->command->info('EMAIL: '.$usuario->email);

    	if ($this->command->confirm('> Confirma este usuário?', true)){
    		User::where('id', $id_user)->update(['password_changed_at' => NULL, 'password' => bcrypt($usuario->login)]);
    		$this->command->info('###### SENHA ALTERADA COM SUCESSO, NOVA SENHA É O LOGIN DE ACESSO #######');
    	}
    }
}
