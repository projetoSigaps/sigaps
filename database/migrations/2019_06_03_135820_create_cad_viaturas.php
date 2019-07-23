<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadViaturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_viaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('automovel_id')->nullable(false)->unsigned();
            $table->integer('vtr_cmt')->nullable(false);
            $table->string('cat', 50)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_viaturas');
    }
}
