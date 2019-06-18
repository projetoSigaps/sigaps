<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadViaturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_viaturas', function(Blueprint $table) {
           $table->foreign('automovel_id')->references('id')->on('cad_automovel')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_viaturas', function(Blueprint $table)
        {
            $table->dropForeign('cad_viaturas_automovel_id_foreign');
        });
    }
}
