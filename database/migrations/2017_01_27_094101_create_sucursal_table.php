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
            $table->string('sucursal_telefono', 15);
            $table->boolean('sucursal_activo')->default(0);
            $table->integer('sucursal_pedn')->unsigned();
            $table->integer('sucursal_entr')->unsigned();
            $table->integer('sucursal_tras')->unsigned();
            $table->integer('sucursal_ajus')->unsigned();
            
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
