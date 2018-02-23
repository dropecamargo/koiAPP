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
        Schema::create('sucursal', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('sucursal_nombre', 200);
            $table->string('sucursal_direccion', 200);
            $table->string('sucursal_direccion_nomenclatura', 200);
            $table->string('sucursal_telefono', 15);
            $table->integer('sucursal_regional')->unsigned();
            $table->integer('sucursal_defecto')->unsigned()->nullable();
            $table->boolean('sucursal_ubicaciones')->default(false);
            $table->integer('sucursal_pedn')->unsigned();
            $table->integer('sucursal_entr')->unsigned();
            $table->integer('sucursal_tras')->unsigned();
            $table->integer('sucursal_ajus')->unsigned();
            $table->integer('sucursal_pedidoc')->unsigned();
            $table->integer('sucursal_devo')->unsigned();
            $table->integer('sucursal_remr')->unsigned();
            $table->integer('sucursal_trau')->unsigned();
            $table->boolean('sucursal_activo')->default(false);

            $table->unique(['sucursal_nombre', 'sucursal_regional']);
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
