<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContenidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('formato_template');
            $table->string('nombre')->unique();
            $table->unsignedInteger('id_archivo_uno')->nullable();
            $table->unsignedInteger('id_archivo_dos')->nullable();
            $table->unsignedInteger('id_archivo_tres')->nullable();
            $table->unsignedInteger('id_archivo_cuatro')->nullable();            
            $table->unsignedInteger('id_estado');
            $table->foreign('id_estado')->references('id')->on('estados')->onDelete('cascade');
            $table->foreign('id_archivo_uno')->references('id')->on('archivos')->onDelete('cascade');
            $table->foreign('id_archivo_dos')->references('id')->on('archivos')->onDelete('cascade');
            $table->foreign('id_archivo_tres')->references('id')->on('archivos')->onDelete('cascade');
            $table->foreign('id_archivo_cuatro')->references('id')->on('archivos')->onDelete('cascade');

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
        Schema::dropIfExists('contenidos');
    }
}

