<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturap2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturap2', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('facturap2_facturap1')->unsigned();
            $table->integer('facturap2_impuesto')->unsigned()->nullable();
            $table->integer('facturap2_retefuente')->unsigned()->nullable();
            $table->double('facturap2_base')->default(0);
            $table->double('facturap2_porcentaje')->default(0);

            $table->foreign('facturap2_facturap1')->references('id')->on('facturap1')->onDelete('restrict');
            $table->foreign('facturap2_impuesto')->references('id')->on('impuesto')->onDelete('restrict');
            $table->foreign('facturap2_retefuente')->references('id')->on('retefuente')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturap2');
    }
}
