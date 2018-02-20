<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('factura2_factura1')->unsigned();
            $table->integer('factura2_producto')->unsigned();
            $table->integer('factura2_linea')->unsigned();
            $table->integer('factura2_cantidad');
            $table->integer('factura2_devueltas');
            $table->double('factura2_costo')->default(0);
            $table->double('factura2_precio_venta')->default(0);
            $table->double('factura2_descuento_valor')->default(0);
            $table->double('factura2_descuento_porcentaje')->default(0);
            $table->double('factura2_iva_valor')->default(0);
            $table->double('factura2_iva_porcentaje')->default(0);
            $table->double('factura2_margen')->default(0);

            $table->foreign('factura2_factura1')->references('id')->on('factura1')->onDelete('restrict');
            $table->foreign('factura2_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('factura2_linea')->references('id')->on('linea')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura2');
    }
}
