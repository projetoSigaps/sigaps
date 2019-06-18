<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadPosto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_posto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 200)->nullable(false);
            $table->string('nome', 200)->nullable(false);
            $table->string('letra', 10)->nullable(false);
            $table->string('ordem', 50)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_posto');
    }
}
