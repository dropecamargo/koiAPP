<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrada1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('entrada1_numero')->unsigned();
            $table->integer('entrada1_sucursal')->unsigned();
            $table->integer('entrada1_documentos')->unsigned();
            $table->integer('entrada1_pedido1')->unsigned()->nullable();
            $table->integer('entrada1_tercero')->unsigned();
            $table->date('entrada1_fecha');
            $table->text('entrada1_observaciones');
            $table->double('entrada1_subtotal');
            $table->double('entrada1_descuento');
            $table->double('entrada1_iva');
            $table->integer('entrada1_usuario_elaboro')->unsigned();
            $table->datetime('entrada1_fh_elaboro');

            $table->foreign('entrada1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('entrada1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('entrada1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('entrada1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada1');
    }
}
