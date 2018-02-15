<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadnegocioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidadnegocio', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('unidadnegocio_nombre', 50);
            $table->boolean('unidadnegocio_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidadnegocio');
    }
}
