<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticipo3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipo3', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('anticipo3_anticipo1')->unsigned();
            $table->integer('anticipo3_conceptosrc')->unsigned();
            $table->string('anticipo3_naturaleza',1);
            $table->double('anticipo3_valor');

            $table->foreign('anticipo3_anticipo1')->references('id')->on('anticipo1')->onDelete('restrict');
            $table->foreign('anticipo3_conceptosrc')->references('id')->on('conceptosrc')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anticipo3');
    }
}
