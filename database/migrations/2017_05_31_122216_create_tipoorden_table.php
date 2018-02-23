<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoordenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoorden', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('tipoorden_nombre',200)->unique();
            $table->integer('tipoorden_tipoajuste')->unsigned();
            $table->boolean('tipoorden_activo')->default(false);

            $table->foreign('tipoorden_tipoajuste')->references('id')->on('tipoajuste')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoorden');
    }
}
