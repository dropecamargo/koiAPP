<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('modelo_nombre', 100);
            $table->integer('modelo_marca')->unsigned();
            $table->boolean('modelo_activo')->default(false);

            $table->unique(['modelo_nombre', 'modelo_marca']);
            $table->foreign('modelo_marca')->references('id')->on('marca')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modelo');
    }
}
