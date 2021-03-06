<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rollo' , function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('rollo_serie')->unsigned();
            $table->integer('rollo_sucursal')->unsigned();
            $table->integer('rollo_ubicacion')->unsigned()->nullable();
            $table->double('rollo_metros')->default(0);
            $table->double('rollo_saldo')->default(0);
            $table->string('rollo_lote',50);
            $table->date('rollo_fecha');

            $table->foreign('rollo_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('rollo_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('rollo_ubicacion')->references('id')->on('ubicacion')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rollo');
    }
}
