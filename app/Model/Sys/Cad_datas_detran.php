<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;

class Cad_datas_detran extends Model
{
    protected $table = 'cad_datas_detran';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'final_placa',
        'dia_vencimento',
        'mes_vencimento',
    ];

    protected $guarded = [
        'id',
        'final_placa',
        'dia_vencimento',
        'mes_vencimento',
    ];
}
