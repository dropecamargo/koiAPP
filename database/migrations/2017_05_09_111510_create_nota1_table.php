<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNota1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('nota1_sucursal')->unsigned();
            $table->integer('nota1_numero');
            $table->integer('nota1_tercero')->unsigned();
            $table->integer('nota1_documentos')->unsigned();
            $table->double('nota1_valor')->default(0);
            $table->date('nota1_fecha');
            $table->text('nota1_observaciones');
            $table->integer('nota1_asiento')->unsigned()->nullable();
            $table->integer('nota1_asienton')->unsigned()->nullable();
            $table->integer('nota1_conceptonota')->unsigned();
            $table->integer('nota1_usuario_elaboro')->unsigned();
            $table->dateTime('nota1_fh_elaboro');

            $table->foreign('nota1_asiento')->references('id')->on('asiento1')->onDelete('restrict');
            $table->foreign('nota1_asienton')->references('id')->on('asienton1')->onDelete('restrict');
            $table->foreign('nota1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('nota1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('nota1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('nota1_conceptonota')->references('id')->on('conceptonota')->onDelete('restrict');
            $table->foreign('nota1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota1');
    }
}
