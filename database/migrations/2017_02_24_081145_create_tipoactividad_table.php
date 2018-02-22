<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoactividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoactividad', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipoactividad_nombre', 25)->unique();
            $table->boolean('tipoactividad_activo')->default(false);
            $table->boolean('tipoactividad_comercial')->default(false);
            $table->boolean('tipoactividad_tecnico')->default(false);
            $table->boolean('tipoactividad_cartera')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoactividad');
    }
}
