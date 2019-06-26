<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadEntradaSaida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_entrada_saida', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('militar_id')->nullable()->unsigned();
            $table->integer('automovel_id')->nullable()->unsigned();
            $table->dateTime('dtEntrada')->nullable();
            $table->dateTime('dtSaida')->nullable();
            $table->boolean('flag')->nullable(false);
            $table->integer('om_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_entrada_saida');
    }
}
