<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolucion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion2',function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('devolucion2_devolucion1')->unsigned();
            $table->integer('devolucion2_producto')->unsigned();
            $table->integer('devolucion2_cantidad');
            $table->double('devolucion2_precio');
            $table->double('devolucion2_costo');
            $table->double('devolucion2_descuento');
            $table->double('devolucion2_iva');
            $table->double('devolucion2_costo_promedio');

            $table->foreign('devolucion2_devolucion1')->references('id')->on('devolucion1')->onDelete('restrict');
            $table->foreign('devolucion2_producto')->references('id')->on('producto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolucion2');
    }
}
