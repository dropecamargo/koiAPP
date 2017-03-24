<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdbodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodbode', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('prodbode_serie')->unsigned();
            $table->integer('prodbode_sucursal')->unsigned();
            $table->integer('prodbode_cantidad')->unsigned();
            $table->integer('prodbode_cantidadA')->unsigned();
            $table->integer('prodbode_cantidadB')->unsigned();
            $table->integer('prodbode_cantidadC')->unsigned();
            $table->integer('prodbode_reservado')->unsigned();
            $table->string('prodbode_ubicacion1',100);
            $table->string('prodbode_ubicacion2',100);
            $table->string('prodbode_ubicacion3',100);
            $table->integer('prodbode_maximo')->unsigned();
            $table->integer('producto_minimo')->unsigned();

            $table->foreign('prodbode_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('prodbode_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            
            $table->unique(['prodbode_serie', 'prodbode_sucursal']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodbode');
    }
}
