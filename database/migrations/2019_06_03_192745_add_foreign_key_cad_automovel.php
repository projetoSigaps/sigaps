<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadAutomovel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_automovel', function(Blueprint $table) {
            $table->foreign('militar_id')->references('id')->on('cad_militar')->onDelete('cascade');
            $table->foreign('tipo_id')->references('id')->on('cad_tipo_automovel')->onDelete('cascade');
            $table->foreign('marca_id')->references('id')->on('cad_marca')->onDelete('cascade');
            $table->foreign('modelo_id')->references('id')->on('cad_modelo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_automovel', function(Blueprint $table)
        {
            $table->dropForeign('cad_automovel_tipo_id_foreign');
            $table->dropForeign('cad_automovel_marca_id_foreign');
            $table->dropForeign('cad_automovel_militar_id_foreign');
            $table->dropForeign('cad_automovel_modelo_id_foreign');
        });
    }
}
