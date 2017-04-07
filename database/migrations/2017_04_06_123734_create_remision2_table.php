<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemision2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remision2', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('remision2_remision1')->unsigned();
            $table->integer('remision2_producto')->unsigned();
            $table->integer('remision2_lote')->unsigned();
            $table->integer('remision2_cantidad_entrada')->unsigned();
            $table->integer('remision2_cantidad_salida')->unsigned();
            $table->double('remision2_costo');      
            $table->double('remision2_costo_promedio');

            $table->foreign('remision2_remision1')->references('id')->on('remision1')->onDelete('restrict');
            $table->foreign('remision2_lote')->references('id')->on('lote')->onDelete('restrict');
            $table->foreign('remision2_producto')->references('id')->on('producto')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('remision2');
    }
}
