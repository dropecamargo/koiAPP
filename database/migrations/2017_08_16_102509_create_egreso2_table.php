<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgreso2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egreso2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('egreso2_egreso1')->unsigned();
            $table->integer('egreso2_tercero')->unsigned();
            $table->integer('egreso2_tipopago')->unsigned();
            $table->integer('egreso2_documentos_doc')->unsigned()->nullable();
            $table->integer('egreso2_id_doc')->unsigned();
            $table->double('egreso2_valor');

            $table->foreign('egreso2_egreso1')->references('id')->on('egreso1')->onDelete('restrict');
            $table->foreign('egreso2_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('egreso2_tipopago')->references('id')->on('tipopago')->onDelete('restrict');
            $table->foreign('egreso2_documentos_doc')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egreso2');
    }
}
