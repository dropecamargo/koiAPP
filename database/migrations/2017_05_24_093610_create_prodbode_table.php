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
            $table->integer('prodbode_cantidad')->default(0)->unsigned();
            $table->double('prodbode_metros')->default(0);
            $table->integer('prodbode_reservado')->unsigned();
            $table->text('prodbode_ubicacion1');
            $table->integer('prodbode_maximo')->unsigned();
            $table->integer('producto_minimo')->unsigned();

            $table->foreign('prodbode_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('prodbode_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
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
