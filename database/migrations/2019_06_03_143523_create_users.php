<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name',100)->nullable(false);
        $table->string('login',50)->unique();
        $table->string('email',100)->nullable(false);
        $table->integer('om_id')->unsigned();
        $table->string('password')->nullable(false);
        $table->timestamps();
        $table->timestamp('password_changed_at')->nullable();
        $table->rememberToken();
    });
 }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
