<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierreinventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierreinventario', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cierreinventario_mes')->unsigned();
            $table->integer('cierreinventario_ano')->unsigned();
            $table->integer('cierreinventario_producto')->unsigned();
            $table->integer('cierreinventario_sucursal')->unsigned();
            $table->integer('cierreinventario_cantidad')->unsigned();
            $table->double('cierreinventario_metros')->default(0);
            $table->double('cierreinventario_costo')->default(0);
            $table->date('cierreinventario_corte');
            $table->dateTime('cierreinventario_fh_elaboro');

            $table->foreign('cierreinventario_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('cierreinventario_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cierreinventario');
    }
}
