<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_entrada_saida extends Model
{
	protected $table = 'cad_entrada_saida';
	public $timestamps = false;
	protected $fillable = [
		'cod_cracha',
		'dtEntrada',
		'dtSaida',
		'cor',
		'placa',
		'marca',
		'modelo',
		'tp',
		'flag'
	];

	protected $guarded = [
		'cod_cracha',
		'dtEntrada',
		'dtSaida',
		'cor',
		'placa',
		'marca',
		'modelo',
		'tp',
		'flag'
	];
}
