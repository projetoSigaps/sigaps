<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadAutomovel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_automovel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('militar_id')->nullable(false)->unsigned();
            $table->integer('modelo_id')->nullable(false)->unsigned();
            $table->integer('marca_id')->nullable(false)->unsigned();
            $table->integer('tipo_id')->nullable(false)->unsigned();
            $table->string('placa', 100)->nullable(false);
            $table->integer('renavan')->nullable(false);
            $table->string('cor', 100)->nullable(false);
            $table->string('doc_venc', 150)->nullable(false);
            $table->string('origem', 150)->nullable(false);
            $table->integer('ano_auto')->nullable(false);
            $table->integer('baixa')->nullable();
            $table->unique('placa');
            $table->unique('renavan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_automovel');
    }
}
