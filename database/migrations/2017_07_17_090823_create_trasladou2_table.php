<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrasladou2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trasladou2', function(Blueprint $table ){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('trasladou2_trasladou1')->unsigned();
            $table->integer('trasladou2_producto')->unsigned();
            $table->integer('trasladou2_item')->unsigned();
            $table->integer('trasladou2_cantidad')->unsigned();

            $table->foreign('trasladou2_trasladou1')->references('id')->on('trasladou1')->onDelete('restrict');
            $table->foreign('trasladou2_producto')->references('id')->on('producto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trasladou2');
    }
}
