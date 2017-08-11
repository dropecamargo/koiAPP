<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjustep2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajustep2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ajustep2_ajustep1')->unsigned();
            $table->integer('ajustep2_tercero')->unsigned();
            $table->integer('ajustep2_documentos_doc')->unsigned();
            $table->integer('ajustep2_id_doc')->unsigned()->nullable();
            $table->string('ajustep2_naturaleza',1);
            $table->double('ajustep2_valor');

            $table->foreign('ajustep2_ajustep1')->references('id')->on('ajustep1')->onDelete('restrict');
            $table->foreign('ajustep2_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('ajustep2_documentos_doc')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajustep2');
    }
}
