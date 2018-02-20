<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturap3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturap3', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('facturap3_facturap1')->unsigned();
            $table->integer('facturap3_cuota')->unsigned();
            $table->date('facturap3_vencimiento');
            $table->double('facturap3_valor')->default(0);
            $table->double('facturap3_saldo')->default(0);

            $table->foreign('facturap3_facturap1')->references('id')->on('facturap1')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturap3');
    }
}
