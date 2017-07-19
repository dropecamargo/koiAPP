<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('lote_serie')->unsigned();
            $table->integer('lote_sucursal')->unsigned();
            $table->integer('lote_ubicacion')->unsigned()->nullable();
            $table->string('lote_numero',50);
            $table->date('lote_fecha');
            $table->date('lote_vencimiento')->nullable();
            $table->integer('lote_cantidad')->unsigned();
            $table->integer('lote_saldo')->unsigned();

            $table->foreign('lote_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('lote_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('lote_ubicacion')->references('id')->on('ubicacion')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lote');
    }
}
