<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clientId');            
            $table->string('ip');            
            $table->unsignedInteger('id_contenido');
            $table->unsignedInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('estados');     
            $table->foreign('id_contenido')->references('id')->on('contenidos');     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}

