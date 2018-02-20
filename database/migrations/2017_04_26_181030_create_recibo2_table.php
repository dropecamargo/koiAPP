<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecibo2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('recibo2_recibo1')->unsigned()->nullable();
            $table->integer('recibo2_conceptosrc')->unsigned()->nullable();
            $table->integer('recibo2_documentos_doc')->unsigned()->nullable();
            $table->integer('recibo2_id_doc')->unsigned()->nullable();
            $table->string('recibo2_naturaleza', 1);
            $table->double('recibo2_valor')->default(0);

            $table->foreign('recibo2_recibo1')->references('id')->on('recibo1')->onDelete('restrict');
            $table->foreign('recibo2_conceptosrc')->references('id')->on('conceptosrc')->onDelete('restrict');
            $table->foreign('recibo2_documentos_doc')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibo2');
    }
}
