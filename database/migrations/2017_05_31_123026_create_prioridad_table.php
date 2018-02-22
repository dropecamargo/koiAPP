<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrioridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prioridad', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('prioridad_nombre', 200)->unique();
            $table->boolean('prioridad_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prioridad');
    }
}
