<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadMarca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_marca', function(Blueprint $table) {
         $table->foreign('tipo_id')->references('id')->on('cad_tipo_automovel')->onDelete('cascade');
     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_marca', function(Blueprint $table)
        {
            $table->dropForeign('cad_marca_tipo_id_foreign');
        });
    }
}
