<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadDatasDetran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_datas_detran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('final_placa')->nullable(false);
            $table->integer('dia_vencimento')->nullable(false);
            $table->integer('mes_vencimento')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_datas_detran');
    }
}
