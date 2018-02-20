<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturap4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturap4', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('facturap4_facturap1')->unsigned();
            $table->integer('facturap4_centrocosto')->unsigned();
            $table->double('facturap4_valor')->default(0);

            $table->foreign('facturap4_facturap1')->references('id')->on('facturap1')->onDelete('restrict');
            $table->foreign('facturap4_centrocosto')->references('id')->on('centrocosto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturap4');
    }
}
