<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjustep1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajustep1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ajustep1_regional')->unsigned();
            $table->integer('ajustep1_numero')->unsigned();
            $table->integer('ajustep1_documentos')->unsigned();
            $table->integer('ajustep1_tercero')->unsigned();
            $table->integer('ajustep1_conceptoajustep')->unsigned();
            $table->text('ajustep1_observaciones');
            $table->integer('ajustep1_usuario_elaboro')->unsigned();
            $table->dateTime('ajustep1_fh_elaboro');

            $table->foreign('ajustep1_regional')->references('id')->on('regional')->onDelete('restrict');
            $table->foreign('ajustep1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('ajustep1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('ajustep1_conceptoajustep')->references('id')->on('conceptoajustep')->onDelete('restrict');
            $table->foreign('ajustep1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *  
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajustep1');
    }
}
