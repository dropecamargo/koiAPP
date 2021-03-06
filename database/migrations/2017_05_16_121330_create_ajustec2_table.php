<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjustec2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajustec2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ajustec2_ajustec1')->unsigned();
            $table->integer('ajustec2_tercero')->unsigned();
            $table->integer('ajustec2_documentos_doc')->unsigned();
            $table->integer('ajustec2_id_doc')->unsigned()->nullable();
            $table->string('ajustec2_naturaleza',1);
            $table->double('ajustec2_valor')->default(0);

            $table->foreign('ajustec2_ajustec1')->references('id')->on('ajustec1')->onDelete('restrict');
            $table->foreign('ajustec2_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('ajustec2_documentos_doc')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajustec2');
    }
}
