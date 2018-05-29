<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajamenor1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajamenor1', function (Blueprint $table){

            $table->engine = "InnoDB";
            $table->increments('id');

            $table->integer('cajamenor1_numero')->unsigned();
            $table->integer('cajamenor1_regional')->unsigned();
            $table->integer('cajamenor1_tercero')->unsigned();
            $table->integer('cajamenor1_documentos')->unsigned();
            $table->double('cajamenor1_fondo');
            $table->double('cajamenor1_efectivo');
            $table->double('cajamenor1_provisionales');
            $table->double('cajamenor1_reembolso');
            $table->date('cajamenor1_fecha');
            $table->text('cajamenor1_observaciones');
            $table->integer('cajamenor1_usuario_elaboro')->unsigned();
            $table->dateTime('cajamenor1_fh_elaboro');

            $table->foreign('cajamenor1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('cajamenor1_regional')->references('id')->on('regional')->onDelete('restrict');
            $table->foreign('cajamenor1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('cajamenor1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');

            $table->unique(['cajamenor1_regional','cajamenor1_numero']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cajamenor1');
    }
}
