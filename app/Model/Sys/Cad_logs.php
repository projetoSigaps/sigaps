<?php

/*

Cad_logs;
Tabela onde é registrado as operações no sistema;
Suas informações aparecem no campo Histórico na pagina de edição do cadastro do militar;

id_operacao: qual id da operação foi executada (Ver Cad_operacao);
id_militar: qual perfil foi alterado;
id_operador: qual usuário fez a ação;
data_hora: data e hora da ação.
endereco_ip: IP do usuário que fez a operação. 

*/

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_logs extends Model
{

	protected $table = 'cad_logs';
	public $timestamps = false;
	protected $fillable = [
		'id_operacao',
		'id_militar', 
		'id_veiculo', 
		'id_operador', 
		'data_hora', 
		'endereco_ip'
	];

	protected $guarded = [
		'id_operacao',
		'id_militar', 
		'id_veiculo', 
		'id_operador', 
		'data_hora', 
		'endereco_ip'
	];
}
