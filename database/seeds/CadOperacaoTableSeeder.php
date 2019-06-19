<?php

use Illuminate\Database\Seeder;

class CadOperacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('cad_operacao')
    	->insert(
    		array(
    			array('evento'=>'CADASTROU', 'descricao'=>'MILITAR'),
    			array('evento'=>'CADASTROU', 'descricao'=>'VEÍCULO'),
                array('evento'=>'CADASTROU', 'descricao'=>'VIATURA'),

                array('evento'=>'EDITOU', 'descricao'=>'DADOS CADASTRAIS DO MILITAR'),
                array('evento'=>'EDITOU', 'descricao'=>'DADOS CADASTRAIS DO VEÍCULO'),
                array('evento'=>'EDITOU', 'descricao'=>'DADOS CADASTRAIS DA VIATURA'),

                array('evento'=>'DESATIVOU MILITAR', 'descricao'=>'TRANSFERIDO P/ OUTRA OM'),
                array('evento'=>'DESATIVOU MILITAR', 'descricao'=>'TRANSFERIDO P/ RESERVA'),
                array('evento'=>'DESATIVOU MILITAR', 'descricao'=>'TÉRMINO DO TEMPO DE SV'),
                array('evento'=>'DESATIVOU MILITAR', 'descricao'=>'DADOS CADASTRAIS INCOMPLETOS'),
                array('evento'=>'DESATIVOU MILITAR', 'descricao'=>'RESTRINÇÃO NA SECÃO DE INTELIGÊNCIA'),
                array('evento'=>'DESATIVOU MILITAR', 'descricao'=>'RESTRINÇÃO EM ORGÃO DE SEGURANÇA'),

                array('evento'=>'DESATIVOU VEÍCULO', 'descricao'=>'PERDA/ROUBO'),
                array('evento'=>'DESATIVOU VEÍCULO', 'descricao'=>'VENDA/TROCA'),
                array('evento'=>'DESATIVOU VEÍCULO', 'descricao'=>'DADOS CADASTRAIS INCOMPLETOS'),
                array('evento'=>'DESATIVOU VEÍCULO', 'descricao'=>'RESTRINÇÃO NA SECÃO DE INTELIGÊNCIA'),
                array('evento'=>'DESATIVOU VEÍCULO', 'descricao'=>'RESTRINÇÃO EM ORGÃO DE SEGURANÇA'),

                array('evento'=>'DESATIVOU VIATURA', 'descricao'=>'DESATIVAÇÃO DE VTR'),

                array('evento'=>'ATIVOU MILITAR', 'descricao'=>'TRANSFERIDO DE OUTRA OM'),
                array('evento'=>'ATIVOU MILITAR', 'descricao'=>'DADOS CADASTRAIS REGULARIZADOS'),
                array('evento'=>'ATIVOU MILITAR', 'descricao'=>'REGULARIZADO NA SEÇÃO DE INTELIGÊNCIA'),
                array('evento'=>'ATIVOU MILITAR', 'descricao'=>'REGULARIZADO NO ORGÃO DE SEGURANÇA'),
                array('evento'=>'ATIVOU MILITAR', 'descricao'=>'CONTRATADO COMO PTTC'),

                array('evento'=>'ATIVOU VEÍCULO', 'descricao'=>'REGULARIZADO NO ORGÃO DE SEGURANÇA'),
                array('evento'=>'ATIVOU VEÍCULO', 'descricao'=>'REGULARIZADO NA SEÇÃO DE INTELIGÊNCIA'),
                array('evento'=>'ATIVOU VEÍCULO', 'descricao'=>'DADOS CADASTRAIS REGULARIZADOS'),
                array('evento'=>'ATIVOU VEÍCULO', 'descricao'=>'ATIVAÇÃO DIVERSA'),

                array('evento'=>'ATIVOU VIATURA', 'descricao'=>'ATIVAÇÃO DE VTR'),

                array('evento'=>'GEROU CRACHÁ', 'descricao'=>'PEDESTRE'),
                array('evento'=>'GEROU CRACHÁ', 'descricao'=>'VEÍCULO'),
                array('evento'=>'GEROU CRACHÁ', 'descricao'=>'VIATURA'),

                array('evento'=>'TROCOU CRACHÁ', 'descricao'=>'PERDA/FURTO DE CRACHÁ')

            ));
    	$this->command->info('cad_operacao table seeded!');
    }
}
