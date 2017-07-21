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
            $table->integer('prodbode_ubicacion')->unsigned()->nullable();
            $table->integer('prodbode_reservado')->unsigned();
            $table->integer('prodbode_maximo')->unsigned();
            $table->integer('prodbode_minimo')->unsigned();
            $table->double('prodbode_metros')->default(0);

            $table->foreign('prodbode_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('prodbode_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('prodbode_ubicacion')->references('id')->on('ubicacion')->onDelete('restrict');
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
