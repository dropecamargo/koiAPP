<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajamenor2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajamenor2', function (Blueprint $table){

            $table->engine = "InnoDB";
            $table->increments('id');

            $table->integer('cajamenor2_cajamenor1')->unsigned();
            $table->integer('cajamenor2_tercero')->unsigned();
            $table->integer('cajamenor2_centrocosto')->unsigned();
            $table->integer('cajamenor2_conceptocajamenor')->unsigned();
            $table->integer('cajamenor2_cuenta')->unsigned();
            $table->double('cajamenor2_subtotal');
            $table->double('cajamenor2_iva');
            $table->double('cajamenor2_retefuente');
            $table->double('cajamenor2_reteiva');
            $table->double('cajamenor2_reteica');
            $table->double('cajamenor2_retecree');

            $table->foreign('cajamenor2_cajamenor1')->references('id')->on('cajamenor1')->onDelete('restrict');
            $table->foreign('cajamenor2_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('cajamenor2_centrocosto')->references('id')->on('centrocosto')->onDelete('restrict');
            $table->foreign('cajamenor2_conceptocajamenor')->references('id')->on('conceptocajamenor')->onDelete('restrict');
            $table->foreign('cajamenor2_cuenta')->references('id')->on('plancuentas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cajamenor2');
    }
}
