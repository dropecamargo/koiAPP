<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacion',function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('ubicacion_nombre',25);
            $table->integer('ubicacion_sucursal')->unsigned();
            $table->boolean('ubicacion_activo')->default(0);

            $table->foreign('ubicacion_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubicacion');
    }
}
