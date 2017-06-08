<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChposfechado2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chposfechado2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('chposfechado2_chposfechado1')->unsigned();
            $table->integer('chposfechado2_conceptosrc')->unsigned();
            $table->integer('chposfechado2_documentos_doc')->unsigned();
            $table->integer('chposfechado2_id_doc')->unsigned()->nullable();
            $table->string('chposfechado2_naturaleza',1);
            $table->double('chposfechado2_valor');

            $table->foreign('chposfechado2_chposfechado1')->references('id')->on('chposfechado1')->onDelete('restrict');
            $table->foreign('chposfechado2_conceptosrc')->references('id')->on('conceptosrc')->onDelete('restrict');
            $table->foreign('chposfechado2_documentos_doc')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chposfechado2');
    }
}
