<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolucion1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion1',function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('devolucion1_sucursal')->unsigned();
            $table->integer('devolucion1_numero')->unsigned();
            $table->integer('devolucion1_documentos')->unsigned();
            $table->integer('devolucion1_tercero')->unsigned();
            $table->integer('devolucion1_factura')->unsigned();
            $table->date('devolucion1_fecha');
            $table->double('devolucion1_bruto')->default(0);
            $table->double('devolucion1_descuento')->default(0);
            $table->double('devolucion1_iva')->default(0);
            $table->double('devolucion1_retencion')->default(0);
            $table->double('devolucion1_total')->default(0);
            $table->text('devolucion1_observaciones');
            $table->integer('devolucion1_usuario_elaboro')->unsigned();
            $table->dateTime('devolucion1_fh_elaboro');

            $table->foreign('devolucion1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('devolucion1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('devolucion1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('devolucion1_factura')->references('id')->on('factura1')->onDelete('restrict');
            $table->foreign('devolucion1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolucion1');
    }
}
