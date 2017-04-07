<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraslado2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslado2', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('traslado2_traslado1')->unsigned();
            $table->integer('traslado2_producto')->unsigned();
            $table->integer('traslado2_lote')->unsigned();
            $table->integer('traslado2_item')->unsigned();
            $table->integer('traslado2_cantidad')->unsigned();
            $table->double('traslado2_costo');

            $table->foreign('traslado2_traslado1')->references('id')->on('traslado1')->onDelete('restrict');
            $table->foreign('traslado2_lote')->references('id')->on('lote')->onDelete('restrict');
            $table->foreign('traslado2_producto')->references('id')->on('producto')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('traslado2');
    }
}
