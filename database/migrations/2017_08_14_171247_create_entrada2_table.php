<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrada2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada2', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('entrada2_entrada1')->unsigned();
            $table->integer('entrada2_producto')->unsigned();
            $table->integer('entrada2_cantidad')->unsigned();
            $table->double('entrada2_valor')->default(0);
            $table->double('entrada2_costo')->default(0);
            $table->double('entrada2_costo_promedio')->default(0);

            $table->foreign('entrada2_entrada1')->references('id')->on('entrada1')->onDelete('restrict');
            $table->foreign('entrada2_producto')->references('id')->on('producto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada2');
    }
}
