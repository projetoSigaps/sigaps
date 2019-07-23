<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadMilitar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_militar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 200)->nullable(false);
            $table->string('nome_guerra', 200)->nullable(false);
            $table->string('ident_militar', 100)->nullable(false);
            $table->string('cep', 50)->nullable(false);
            $table->string('estado', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('endereco', 150)->nullable();
            $table->string('numero', 150)->nullable();
            $table->integer('posto')->nullable(false)->unsigned();
            $table->string('cnh', 50)->nullable();
            $table->string('cnh_cat', 50)->nullable();
            $table->string('cnh_venc', 50)->nullable();
            $table->string('celular', 50)->nullable();
            $table->integer('om_id')->nullable(false)->unsigned();
            $table->string('datafile',150)->nullable(false);
            $table->boolean('status')->nullable(false);
            $table->unique('ident_militar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_militar');
    }
}
