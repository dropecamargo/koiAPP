<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraslado1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslado1', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('traslado1_numero')->unsigned();
            $table->integer('traslado1_origen')->unsigned();
            $table->integer('traslado1_destino')->unsigned();
            $table->integer('traslado1_documentos')->unsigned();
            $table->date('traslado1_fecha');
            $table->text('traslado1_observaciones');
            $table->integer('traslado1_usuario_elaboro')->unsigned();
            $table->date('traslado1_fh_elaboro');
            
            $table->foreign('traslado1_origen')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('traslado1_destino')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('traslado1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('traslado1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('traslado1');
    }
}
