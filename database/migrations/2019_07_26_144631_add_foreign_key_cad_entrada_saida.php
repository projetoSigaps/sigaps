<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadEntradaSaida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_entrada_saida', function(Blueprint $table) {
            $table->foreign('militar_id')->references('id')->on('cad_militar')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('automovel_id')->references('id')->on('cad_automovel')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('om_id')->references('id')->on('cad_om')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_entrada_saida', function(Blueprint $table)
        {
            $table->dropForeign('cad_entrada_saida_militar_id_foreign');
            $table->dropForeign('cad_entrada_saida_automovel_id_foreign');
            $table->dropForeign('cad_entrada_saida_om_id_foreign');
        });
    }
}
