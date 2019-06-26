<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_entrada_saida extends Model
{
	protected $table = 'cad_entrada_saida';
	public $timestamps = false;
	protected $fillable = [
		'militar_id',
		'dtEntrada',
		'dtSaida',
		'automovel_id',
		'flag',
		'om_id',
	];

	protected $guarded = [
		'militar_id',
		'dtEntrada',
		'dtSaida',
		'automovel_id',
		'flag',
		'om_id',
	];
}
