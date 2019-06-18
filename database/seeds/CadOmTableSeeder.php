<?php

use Illuminate\Database\Seeder;

class CadOmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $this->command->info('####### ATENÇÃO! #######');
            $this->command->info('- LOGO ABAIXO, SERÁ CRIADO A PRIMEIRA ORGANIZAÇÃO MILITAR');
            $this->command->info('- APÓS O CADASTRO, É IMPORTANTE QUE TERMINE DE PREENCHER OS DADOS VIA SISTEMA');
            $this->command->info('########################');
            $descricao = $this->command->ask('# 1 - Digite o nome completo da OM');
            $nome = $this->command->ask('# 2 - Digite o nome abreviado da OM');
            $codom = $this->command->ask('# 3 - Digite o CODOM da OM');

            DB::table('cad_om')->insert([
                'nome' => strtoupper($nome),
                'descricao' => strtoupper($descricao),
                'codom' => $codom,
                'cep' => '0000-000',
                'datafile' => base64_encode($nome)
            ]);
            $this->command->info('####### ATENÇÃO! #######');
            $this->command->info('- NÃO ESQUEÇA DE ACESSAR O SISTEMA PARA COMPLETAR OS DEMAIS DADOS');
            $this->command->info('####### OM CRIADA COM SUCESSO! #######');
        }
    }
}
