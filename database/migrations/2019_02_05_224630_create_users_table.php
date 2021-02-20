<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('google_id');            
            $table->string('user');
            $table->string('password');
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->unsignedInteger('id_rol');
            $table->unsignedInteger('id_estado');

            $table->string('tipoLogeo');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_rol')->references('id')->on('roles');        
            $table->foreign('id_estado')->references('id')->on('estados');        
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
