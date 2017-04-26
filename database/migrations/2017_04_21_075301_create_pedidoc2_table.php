<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoc2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidoc2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('pedidoc2_pedidoc1')->unsigned();
            $table->integer('pedidoc2_producto')->unsigned();
            $table->integer('pedidoc2_cantidad')->unsigned();
            $table->integer('pedidoc2_facturada')->unsigned();
            $table->double('pedidoc2_costo');
            $table->double('pedidoc2_precio_venta');
            $table->double('pedidoc2_descuento_valor');
            $table->double('pedidoc2_descuento_porcentaje');
            $table->double('pedidoc2_iva_valor');
            $table->double('pedidoc2_iva_porcentaje');
            $table->integer('pedidoc2_subcategoria')->unsigned();
            $table->double('pedidoc2_margen');

            $table->foreign('pedidoc2_pedidoc1')->references('id')->on('pedidoc1')->onDelete('restrict');
            $table->foreign('pedidoc2_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('pedidoc2_subcategoria')->references('id')->on('subcategoria')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidoc2');
    }
}
