<?php

use Illuminate\Database\Seeder;
use App\Model\Sys\Cad_om;


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

            $om = new Cad_om;
			$om->nome = strtoupper(trim($nome));
			$om->descricao = strtoupper(trim($descricao));
			$om->codom = $codom;
			$om->cep = "0000-000";
			$om->datafile = base64_encode($nome);
			$om->save();

            DB::table('cad_militar')->insert([
                'nome' => strtoupper($descricao),
                'nome_guerra' => strtoupper("viatura militar"),
                'ident_militar' => $codom,
                'cep' => '0000-000',
                'om_id' => $om->id,
                'posto' => 34,
                'status' => 1,
                'datafile' => base64_encode($nome)
            ]);

            $this->command->info('####### ATENÇÃO! #######');
            $this->command->info('- NÃO ESQUEÇA DE ACESSAR O SISTEMA PARA COMPLETAR OS DEMAIS DADOS');
            $this->command->info('####### OM CRIADA COM SUCESSO! #######');
        }
    }
}
