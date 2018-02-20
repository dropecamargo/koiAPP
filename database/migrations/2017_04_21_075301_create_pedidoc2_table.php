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
            $table->integer('pedidoc2_linea')->unsigned();
            $table->double('pedidoc2_costo')->default(0);
            $table->double('pedidoc2_precio_venta')->default(0);
            $table->double('pedidoc2_descuento_valor')->default(0);
            $table->double('pedidoc2_descuento_porcentaje')->default(0);
            $table->double('pedidoc2_iva_valor')->default(0);
            $table->double('pedidoc2_iva_porcentaje')->default(0);
            $table->double('pedidoc2_margen')->default(0);

            $table->foreign('pedidoc2_linea')->references('id')->on('linea')->onDelete('restrict');
            $table->foreign('pedidoc2_pedidoc1')->references('id')->on('pedidoc1')->onDelete('restrict');
            $table->foreign('pedidoc2_producto')->references('id')->on('producto')->onDelete('restrict');
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
