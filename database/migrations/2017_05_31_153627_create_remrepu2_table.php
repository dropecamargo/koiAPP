<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemrepu2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remrepu2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('remrepu2_producto')->unsigned();
            $table->integer('remrepu2_remrepu1')->unsigned();
            $table->integer('remrepu2_cantidad')->unsigned();
            $table->integer('remrepu2_facturado')->unsigned();
            $table->integer('remrepu2_no_facturado')->unsigned();
            $table->integer('remrepu2_devuelto')->unsigned();
            
            $table->foreign('remrepu2_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('remrepu2_remrepu1')->references('id')->on('remrepu1')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remrepu2');
    }
}
