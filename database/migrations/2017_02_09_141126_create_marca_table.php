<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marca', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('marca_nombre',200)->comment = "Es el nombre de la MARCA";
            $table->boolean('marca_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marca');
    }
}
