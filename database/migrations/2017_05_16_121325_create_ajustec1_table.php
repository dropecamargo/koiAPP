<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjustec1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajustec1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ajustec1_sucursal')->unsigned();
            $table->integer('ajustec1_numero')->unsigned();
            $table->integer('ajustec1_documentos')->unsigned();
            $table->integer('ajustec1_tercero')->unsigned();
            $table->integer('ajustec1_conceptoajustec')->unsigned();
            $table->text('ajustec1_observaciones');
            $table->integer('ajustec1_usuario_elaboro')->unsigned();
            $table->dateTime('ajustec1_fh_elaboro');

            $table->foreign('ajustec1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('ajustec1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('ajustec1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('ajustec1_conceptoajustec')->references('id')->on('conceptoajustec')->onDelete('restrict');
            $table->foreign('ajustec1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajustec1');
    }
}
