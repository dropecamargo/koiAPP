<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursal', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('sucursal_regional')->unsigned();
            $table->string('sucursal_nombre', 200);
            $table->string('sucursal_direccion', 200);
            $table->string('sucursal_direccion_nomenclatura', 200);
            $table->string('sucursal_telefono', 15);
            $table->boolean('sucursal_activo')->default(0);
            $table->integer('sucursal_pedn')->unsigned();
            $table->integer('sucursal_entr')->unsigned();
            $table->integer('sucursal_tras')->unsigned();
            $table->integer('sucursal_ajus')->unsigned();
            $table->integer('sucursal_pedidoc')->unsigned();
            $table->integer('sucursal_reci')->unsigned();
            $table->integer('sucursal_nota')->unsigned();
            $table->integer('sucursal_devo')->unsigned();
            $table->integer('sucursal_ajuc')->unsigned();
            $table->integer('sucursal_anti')->unsigned();
            $table->integer('sucursal_chp')->unsigned();
            $table->integer('sucursal_chd')->unsigned();
            $table->integer('sucursal_ord')->unsigned();
            $table->integer('sucursal_remr')->unsigned();
            
            $table->foreign('sucursal_regional')->references('id')->on('regional')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sucursal');
    }
}
