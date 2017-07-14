<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNota2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('nota2_nota1')->unsigned();
            $table->integer('nota2_documentos_doc')->unsigned();
            $table->integer('nota2_id_doc')->unsigned();
            $table->double('nota2_valor');

            $table->foreign('nota2_nota1')->references('id')->on('nota1')->onDelete('restrict');
            $table->foreign('nota2_documentos_doc')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota2');
    }
}
