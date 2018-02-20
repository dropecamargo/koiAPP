<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura3', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('factura3_factura1')->unsigned();
            $table->integer('factura3_cuota');
            $table->double('factura3_valor')->default(0);
            $table->double('factura3_saldo')->default(0);
            $table->date('factura3_vencimiento');
            $table->date('factura3_fecha_pago');
            $table->integer('factura3_chposfechado1')->unsigned()->nullable();

            $table->foreign('factura3_factura1')->references('id')->on('factura1')->onDelete('restrict');
            $table->foreign('factura3_chposfechado1')->references('id')->on('chposfechado1')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura3');
    }
}
