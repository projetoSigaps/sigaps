<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCadMilitar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cad_militar', function(Blueprint $table) {
           $table->foreign('om_id')->references('id')->on('cad_om')->onDelete('cascade');
           $table->foreign('posto')->references('id')->on('cad_posto')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cad_militar', function(Blueprint $table)
        {
            $table->dropForeign('cad_militar_om_id_foreign');
            $table->dropForeign('cad_militar_posto_foreign');
        });
    }
}
