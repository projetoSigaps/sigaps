<?php

/*

Cad_operacao;
Table onde possui as operações que serão salva na tabela Cad_logs;

*/




namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_operacao extends Model
{

	protected $table = 'cad_operacao';
	public $timestamps = false;
	protected $fillable = [
		'evento',
		'descricao'
	];

	protected $guarded = [
		'evento',
		'descricao'
	];
}
