<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecibo3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo3', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('recibo3_recibo1')->unsigned();
            $table->integer('recibo3_mediopago')->unsigned();
            $table->string('recibo3_numero_medio', 25);
            $table->dateTime('recibo3_vence_medio')->nullable();
            $table->integer('recibo3_banco_medio')->unsigned()->nullable();
            $table->double('recibo3_valor');

            $table->foreign('recibo3_recibo1')->references('id')->on('recibo1')->onDelete('restrict');
            $table->foreign('recibo3_mediopago')->references('id')->on('mediopago')->onDelete('restrict');
            $table->foreign('recibo3_banco_medio')->references('id')->on('banco')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibo3');
    }
}
