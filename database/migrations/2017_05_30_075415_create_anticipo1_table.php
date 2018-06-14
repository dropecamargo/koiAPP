<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticipo1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anticipo1', function(Blueprint $table){

            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('anticipo1_sucursal')->unsigned();
            $table->integer('anticipo1_numero')->unsigned();
            $table->integer('anticipo1_tercero')->unsigned();
            $table->integer('anticipo1_vendedor')->unsigned();
            $table->integer('anticipo1_documentos')->unsigned();
            $table->integer('anticipo1_cuentas')->unsigned();
            $table->integer('anticipo1_asiento')->unsigned()->nullable();
            $table->integer('anticipo1_asienton')->unsigned()->nullable();
            $table->double('anticipo1_valor')->default(0);
            $table->double('anticipo1_saldo')->default(0);
            $table->date('anticipo1_fecha');
            $table->text('anticipo1_observaciones');
            $table->integer('anticipo1_usuario_elaboro')->unsigned();
            $table->dateTime('anticipo1_fh_elaboro');

            $table->foreign('anticipo1_asiento')->references('id')->on('asiento1')->onDelete('restrict');
            $table->foreign('anticipo1_asienton')->references('id')->on('asienton1')->onDelete('restrict');
            $table->foreign('anticipo1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('anticipo1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('anticipo1_vendedor')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('anticipo1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('anticipo1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('anticipo1_cuentas')->references('id')->on('cuentabanco')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anticipo1');
    }
}
