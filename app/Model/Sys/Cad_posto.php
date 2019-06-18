<?php

/*

Cad_posto;
Tabela onde é armazenado os postos e graduações;
Necessário para vincular ao cadastro do militar e do usuário;

*/
namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_posto extends Model
{

	protected $table = 'cad_posto';
	public $timestamps = false;
	protected $fillable = [
		'nome',
		'tipo',
		'letra',
		'ordem'
	];

	protected $guarded = [
		'nome',
		'tipo',
		'letra',
		'ordem'
	];
}
