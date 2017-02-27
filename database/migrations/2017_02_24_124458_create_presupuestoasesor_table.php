<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestoasesorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestoasesor', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('presupuestoasesor_asesor')->unsigned();
            $table->integer('presupuestoasesor_categoria')->unsigned();
            $table->integer('presupuestoasesor_ano');
            $table->integer('presupuestoasesor_mes');
            $table->double('presupuestoasesor_valor');

            $table->foreign('presupuestoasesor_asesor')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('presupuestoasesor_categoria')->references('id')->on('categoria')->onDelete('restrict');

            $table->unique(['presupuestoasesor_asesor', 'presupuestoasesor_categoria','presupuestoasesor_ano','presupuestoasesor_mes'], 'presupuestoasesor_asesor_categoria_ano_mes_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestoasesor');
    }
}
