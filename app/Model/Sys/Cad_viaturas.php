<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_viaturas extends Model
{
	protected $table = 'cad_viaturas';
	public $timestamps = false;
	protected $fillable = [
		'id',
		'automovel_id',
		'cat',
		'vtr_cmt',
	];

	protected $guarded = [
		'id',
		'automovel_id',
		'cat',
		'vtr_cmt',
	];
}
