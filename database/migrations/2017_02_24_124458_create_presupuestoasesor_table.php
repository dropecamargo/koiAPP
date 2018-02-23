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
            $table->integer('presupuestoasesor_regional')->unsigned();
            $table->integer('presupuestoasesor_linea')->unsigned();
            $table->integer('presupuestoasesor_ano');
            $table->integer('presupuestoasesor_mes');
            $table->double('presupuestoasesor_valor')->default(0);

            $table->foreign('presupuestoasesor_asesor')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('presupuestoasesor_regional')->references('id')->on('regional')->onDelete('restrict');
            $table->foreign('presupuestoasesor_linea')->references('id')->on('linea')->onDelete('restrict');

            $table->unique(['presupuestoasesor_asesor', 'presupuestoasesor_regional','presupuestoasesor_ano','presupuestoasesor_mes'], 'presupuestoasesor_asesor_regional_ano_mes_unique');
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
