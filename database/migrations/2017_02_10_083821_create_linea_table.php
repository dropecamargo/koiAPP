<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('linea_nombre', 50);
            $table->boolean('linea_activo')->default(false);
            $table->integer('linea_unidadnegocio')->unsigned();

            $table->foreign('linea_unidadnegocio')->references('id')->on('unidadnegocio')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('linea');
    }
}
