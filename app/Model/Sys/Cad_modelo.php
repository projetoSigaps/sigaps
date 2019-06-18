<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_modelo extends Model
{

	protected $table = 'cad_modelo';
	public $timestamps = false;
	protected $fillable = [
		'nome',
		'id',
		'marca_id',
		'tipo_id'
	];

	protected $guarded = [
		'nome',
		'id',
		'marca_id',
		'tipo_id'
	];
}
