<?php
/*

Cad_militar;
Tabela onde é registrado os dados do militares;

status: número dois (2) para desativado no sistema e um (1) para ativado.
datafile: nome da foto de perfil do militar.

*/

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_militar extends Model
{

	protected $table = 'cad_militar';
	public $timestamps = false;
	protected $fillable = [
		'nome',
		'nome_guerra',
		'ident_militar',
		'cep',
		'estado',
		'cidade',
		'bairro',
		'endereco',
		'numero',
		'celular',
		'cnh',
		'cnh_cat',
		'cnh_venc',
		'om_id',
		'posto',
		'datafile',
		'status'
	];

	protected $guarded = [
		'nome',
		'nome_guerra',
		'ident_militar',
		'cep',
		'estado',
		'cidade',
		'bairro',
		'endereco',
		'numero',
		'celular',
		'cnh',
		'cnh_cat',
		'cnh_venc',
		'om_id',
		'posto',
		'datafile',
		'status'
	];
}
