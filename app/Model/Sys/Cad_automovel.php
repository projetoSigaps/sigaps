<?php


namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_automovel extends Model
{

	protected $table = 'cad_automovel';
	public $timestamps = false;
	protected $fillable = [
		'id',
		'militar_id',
		'modelo_id',
		'marca_id',
		'tipo_id',
		'placa',
		'renavan',
		'cor',
		'doc_venc',
		'origem',
		'ano_auto',
		'baixa'
	];

	protected $guarded = [
		'id',
		'militar_id',
		'modelo_id',
		'marca_id',
		'tipo_id',
		'placa',
		'renavan',
		'cor',
		'doc_venc',
		'origem',
		'ano_auto',
		'baixa'
	];
}
