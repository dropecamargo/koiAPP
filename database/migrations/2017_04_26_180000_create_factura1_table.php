<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactura1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('factura1_numero');
            $table->string('factura1_prefijo', 5);
            $table->integer('factura1_documentos')->unsigned();
            $table->integer('factura1_puntoventa')->unsigned();
            $table->integer('factura1_sucursal')->unsigned();
            $table->integer('factura1_tercero')->unsigned();
            $table->integer('factura1_tercerocontacto')->unsigned();
            $table->integer('factura1_cuotas');
            $table->integer('factura1_plazo');
            $table->date('factura1_primerpago');
            $table->integer('factura1_vendedor')->unsigned();
            $table->double('factura1_bruto');
            $table->double('factura1_descuento');
            $table->double('factura1_iva');
            $table->double('factura1_retencion');
            $table->double('factura1_total');
            $table->text('factura1_observaciones');
            $table->integer('factura1_pedidoc1')->unsigned()->nullable();
            $table->boolean('factura1_anulada')->default(false);
            $table->integer('factura1_usuario_elaboro')->unsigned()->nullable();
            $table->dateTime('factura1_fh_elaboro');
            $table->integer('factura1_usuario_anulo')->unsigned()->nullable();
            $table->dateTime('factura1_fh_anulo')->nullable();

            $table->foreign('factura1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('factura1_puntoventa')->references('id')->on('puntoventa')->onDelete('restrict');
            $table->foreign('factura1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('factura1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('factura1_tercerocontacto')->references('id')->on('tcontacto')->onDelete('restrict');
            $table->foreign('factura1_vendedor')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('factura1_pedidoc1')->references('id')->on('pedidoc1')->onDelete('restrict');

            $table->unique(['factura1_sucursal','factura1_numero']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura1');
    }
}
