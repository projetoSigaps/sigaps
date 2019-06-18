<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_marca extends Model
{

	protected $table = 'cad_marca';
	public $timestamps = false;
	protected $fillable = [
		'nome',
		'id',
		'tipo_id'
	];

	protected $guarded = [
		'nome',
		'id',
		'tipo_id'
	];
}
