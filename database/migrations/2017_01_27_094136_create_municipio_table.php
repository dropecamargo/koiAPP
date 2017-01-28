<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipio', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('municipio_codigo', 3); 
            $table->string('municipio_nombre', 200); 
            $table->string('departamento_codigo', 2); 

            $table->foreign('departamento_codigo')->references('departamento_codigo')->on('departamento')->onDelete('restrict');
            $table->unique(['departamento_codigo', 'municipio_codigo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipio');
    }
}
