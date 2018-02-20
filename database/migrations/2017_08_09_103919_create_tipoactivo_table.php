<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoactivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoactivo', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipoactivo_nombre', 50);
            $table->integer('tipoactivo_vida_util')->unsigned();
            $table->boolean('tipoactivo_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoactivo');
    }
}
