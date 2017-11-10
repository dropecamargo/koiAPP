<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategoria', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('subcategoria_nombre', 25);
            $table->double('subcategoria_margen_nivel1');
            $table->double('subcategoria_margen_nivel2');
            $table->double('subcategoria_margen_nivel3');
            $table->boolean('subcategoria_activo')->default(false);
            $table->integer('subcategoria_categoria')->unsigned();

            $table->foreign('subcategoria_categoria')->references('id')->on('categoria')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategoria'); 
    }
}
