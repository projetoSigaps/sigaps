<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadOm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_om', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 200)->nullable(false);
            $table->string('descricao', 200)->nullable(false);
            $table->string('codom', 100)->nullable(false);
            $table->string('cep', 50)->nullable(false);
            $table->string('estado', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('endereco', 150)->nullable();
            $table->string('bairro', 150)->nullable();
            $table->string('numero', 150)->nullable();
            $table->string('cor_cracha', 100)->nullable();
            $table->string('datafile',150)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_om');
    }
}
