<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecibo1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('recibo1_sucursal')->unsigned();
            $table->integer('recibo1_numero');
            $table->integer('recibo1_tercero')->unsigned();
            $table->date('recibo1_fecha');
            $table->date('recibo1_fecha_pago');
            $table->double('recibo1_valor')->default(0);
            $table->integer('recibo1_cuentas')->unsigned();
            $table->integer('recibo1_documentos')->unsigned();
            $table->text('recibo1_observaciones');
            $table->integer('recibo1_usuario_elaboro')->unsigned();
            $table->dateTime('recibo1_fh_elaboro');

            $table->foreign('recibo1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('recibo1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('recibo1_cuentas')->references('id')->on('cuentabanco')->onDelete('restrict');
            $table->foreign('recibo1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('recibo1_documentos')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibo1');
    }
}
