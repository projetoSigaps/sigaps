<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_logs', function(Blueprint $table) {
            $table->foreign('id_operacao')->references('id')->on('cad_operacao')->onDelete('cascade');
            $table->foreign('id_operador')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_logs', function(Blueprint $table)
        {
            $table->dropForeign('cad_logs_id_operacao_foreign');
            $table->dropForeign('cad_logs_id_operador_foreign');
        });
    }
}
