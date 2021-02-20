<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            //leyes normales 1 - 3, unico, secuencial
            $table->increments('id');            
            //nombre funcional del archivo
            $table->string('nombre');
            //Si es s3 o youtube
            $table->string('ubicacion');
            //Si es Imagen, video o texto
            $table->string('tipo');  
            //Si el campo es texto
            $table->string('texto_archivo',255);
            $table->string('youtube_url');
            //auditoria
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
        Schema::dropIfExists('archivos');
    }
}
