<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticipo2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipo2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('anticipo2_anticipo1')->unsigned();
            $table->integer('anticipo2_mediopago')->unsigned();
            $table->string('anticipo2_numero_medio',25);
            $table->dateTime('anticipo2_vence_medio')->nullable();
            $table->integer('anticipo2_banco_medio')->unsigned()->nullable();
            $table->double('anticipo2_valor')->default(0);

            $table->foreign('anticipo2_anticipo1')->references('id')->on('anticipo1')->onDelete('restrict');
            $table->foreign('anticipo2_mediopago')->references('id')->on('mediopago')->onDelete('restrict');
            $table->foreign('anticipo2_banco_medio')->references('id')->on('banco')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anticipo2');
    }
}
