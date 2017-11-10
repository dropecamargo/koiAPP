<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('categoria_nombre', 25);
            $table->boolean('categoria_activo')->default(false);
            $table->integer('categoria_linea')->unsigned();

            $table->foreign('categoria_linea')->references('id')->on('linea')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria'); 
    }
}
