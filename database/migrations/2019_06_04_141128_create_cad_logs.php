<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCadLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cad_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_operacao')->nullable()->unsigned();
            $table->integer('id_militar')->nullable()->unsigned();
            $table->integer('id_veiculo')->nullable()->unsigned();
            $table->integer('id_operador')->nullable()->unsigned();
            $table->string('endereco_ip', 50)->nullable(false);
            $table->timestamp('data_hora')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cad_logs');
    }
}
