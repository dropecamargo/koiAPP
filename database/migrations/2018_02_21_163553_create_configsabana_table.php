<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsabanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configsabanaventa', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');

            $table->integer('configsabanaventa_linea')->unsigned();
            $table->integer('configsabanaventa_unificacion')->unsigned();
            $table->string('configsabanaventa_unificacion_nombre', 50);
            $table->integer('configsabanaventa_agrupacion')->unsigned();
            $table->string('configsabanaventa_agrupacion_nombre', 50);
            $table->integer('configsabanaventa_orden_impresion')->unsigned();
            $table->integer('configsabanaventa_grupo')->unsigned();
            $table->string('configsabanaventa_grupo_nombre', 50);
            $table->integer('configsabanaventa_usuario_elaboro')->unsigned();
            $table->dateTime('configsabanaventa_fh_elaboro');


            $table->foreign('configsabanaventa_linea')->references('id')->on('linea')->onDelete('restrict');
            $table->foreign('configsabanaventa_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configsabanaventa');
    }
}
