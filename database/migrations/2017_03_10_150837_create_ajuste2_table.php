<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjuste2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajuste2', function (Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ajuste2_ajuste1')->unsigned();
            $table->integer('ajuste2_producto')->unsigned();
            $table->integer('ajuste2_cantidad_entrada')->unsigned();
            $table->integer('ajuste2_cantidad_salida')->unsigned();
            $table->double('ajuste2_costo');      
            $table->double('ajuste2_costo_promedio');

            $table->foreign('ajuste2_ajuste1')->references('id')->on('ajuste1')->onDelete('restrict');
            $table->foreign('ajuste2_producto')->references('id')->on('producto')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('ajuste2');
    }
}
