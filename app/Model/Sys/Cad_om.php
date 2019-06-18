<?php

/*

Cad_om;
Tabela onde é armazenado as Organizações Militares;
Necessário para vincular ao cadastro do militar e do usuário;

*/

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_om extends Model
{

	protected $table = 'cad_om';
	public $timestamps = false;
	protected $fillable = [
		'nome',
		'descricao',
		'codom',
		'cep',
		'estado',
		'cidade',
		'bairro',
		'endereco',
		'numero',
		'datafile'

	];

	protected $guarded = [
		'nome',
		'descricao',
		'codom',
		'cep',
		'estado',
		'cidade',
		'bairro',
		'endereco',
		'numero',
		'datafile'
	];
}
