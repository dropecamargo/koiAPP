<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedido2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido2', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('pedido2_pedido1')->unsigned();
            $table->integer('pedido2_serie')->unsigned();
            $table->integer('pedido2_cantidad')->unsigned();
            $table->double('pedido2_saldo')->default(0);
            $table->double('pedido2_precio');

            $table->foreign('pedido2_pedido1')->references('id')->on('pedido1')->onDelete('restrict');
            $table->foreign('pedido2_serie')->references('id')->on('producto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido2');
    }
}
