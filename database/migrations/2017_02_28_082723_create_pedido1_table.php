<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedido1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido1', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('pedido1_numero')->unsigned();
            $table->integer('pedido1_sucursal')->unsigned();
            $table->integer('pedido1_tercero')->unsigned();
            $table->integer('pedido1_documentos')->unsigned();
            $table->date('pedido1_fecha');
            $table->date('pedido1_fecha_estimada');
            $table->double('pedido1_anticipo');
            $table->date('pedido1_fecha_anticipo');
            $table->text('pedido1_observaciones');
            $table->boolean('pedido1_anulado');
            $table->boolean('pedido1_cerrado');
            $table->integer('pedido1_usuario_elaboro')->unsigned();
            $table->date('pedido1_fh_elaboro');
            
             $table->foreign('pedido1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
             $table->foreign('pedido1_tercero')->references('id')->on('tercero')->onDelete('restrict');
             $table->foreign('pedido1_documentos')->references('id')->on('documentos')->onDelete('restrict');
             $table->foreign('pedido1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido1');
    }
}
