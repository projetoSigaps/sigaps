<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_viaturas extends Model
{
	protected $table = 'cad_viaturas';
	public $timestamps = false;
	protected $fillable = [
		'id',
		'om_id',
		'modelo_id',
		'marca_id',
		'tipo_id',
		'placa',
		'renavam',
		'cor',
		'venc_doc',
		'cat',
		'vtr_cmt',
		'status',
		'ano'
	];

	protected $guarded = [
		'id',
		'om_id',
		'modelo_id',
		'marca_id',
		'tipo_id',
		'placa',
		'renavam',
		'cor',
		'venc_doc',
		'cat',
		'vtr_cmt',
		'status',
		'ano'
	];
}
