<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadModelo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_modelo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_id')->nullable(false)->unsigned();
            $table->integer('marca_id')->nullable(false)->unsigned();
            $table->string('nome', 200)->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('cad_modelo');
   }
}
