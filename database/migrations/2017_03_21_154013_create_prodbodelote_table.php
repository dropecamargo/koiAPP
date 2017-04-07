<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdbodeloteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodbodelote', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('prodbodelote_lote')->unsigned();
            $table->integer('prodbodelote_serie')->unsigned();
            $table->integer('prodbodelote_sucursal')->unsigned();
            $table->integer('prodbodelote_cantidad')->unsigned();
            $table->integer('prodbodelote_saldo')->unsigned();

            $table->foreign('prodbodelote_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('prodbodelote_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('prodbodelote_lote')->references('id')->on('lote')->onDelete('restrict');

            $table->unique(['prodbodelote_serie', 'prodbodelote_sucursal', 'prodbodelote_lote'],'lote_seie_sucursal_unique');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodbodelote');
    }
}
