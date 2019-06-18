<?php


namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_tipo_automovel extends Model
{

	protected $table = 'cad_tipo_automovel';
	public $timestamps = false;
	protected $fillable = [
		'id',
		'nome'
	];

	protected $guarded = [
		'id',
		'nome'
	];
}
