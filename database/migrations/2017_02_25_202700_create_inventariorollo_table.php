<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariorolloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventariorollo', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('inventariorollo_inventario')->unsigned();
            $table->integer('inventariorollo_item');
            $table->double('inventariorollo_metros_entrada')->default(0);
            $table->double('inventariorollo_metros_salida')->default(0);
            $table->double('inventariorollo_costo')->default(0);

            $table->foreign('inventariorollo_inventario')->references('id')->on('inventario')->onDelete('restrict');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventariorollo');
    }
}
