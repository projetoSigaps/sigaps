<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadModelo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_modelo', function(Blueprint $table) {
           $table->foreign('tipo_id')->references('id')->on('cad_tipo_automovel')->onDelete('cascade');
           $table->foreign('marca_id')->references('id')->on('cad_marca')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_modelo', function(Blueprint $table)
        {
            $table->dropForeign('cad_modelo_tipo_id_foreign');
            $table->dropForeign('cad_modelo_marca_id_foreign');
        });
    }
}
