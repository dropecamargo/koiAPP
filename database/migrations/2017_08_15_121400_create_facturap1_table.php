<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturap1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturap1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('facturap1_regional')->unsigned();
            $table->integer('facturap1_numero')->unsigned();
            $table->integer('facturap1_entrada1')->unsigned()->nullable();
            $table->integer('facturap1_documentos')->unsigned();
            $table->integer('facturap1_tercero')->unsigned();
            $table->integer('facturap1_tipoproveedor')->unsigned();
            $table->integer('facturap1_tipogasto')->unsigned();
            $table->integer('facturap1_cuotas')->unsigned();
            $table->integer('facturap1_asiento')->unsigned()->nullable();
            $table->integer('facturap1_asienton')->unsigned()->nullable();
            $table->date('facturap1_fecha');
            $table->date('facturap1_vencimiento');
            $table->string('facturap1_factura', 20);
            $table->date('facturap1_primerpago');
            $table->double('facturap1_subtotal')->default(0);
            $table->double('facturap1_descuento')->default(0);
            $table->double('facturap1_base')->default(0);
            $table->double('facturap1_impuestos')->default(0);
            $table->double('facturap1_retenciones')->default(0);
            $table->double('facturap1_apagar')->default(0);
            $table->text('facturap1_observaciones');

            $table->foreign('facturap1_asiento')->references('id')->on('asiento1')->onDelete('restrict');
            $table->foreign('facturap1_asienton')->references('id')->on('asienton1')->onDelete('restrict');
            $table->foreign('facturap1_entrada1')->references('id')->on('entrada1')->onDelete('restrict');
            $table->foreign('facturap1_regional')->references('id')->on('regional')->onDelete('restrict');
            $table->foreign('facturap1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('facturap1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('facturap1_tipoproveedor')->references('id')->on('tipoproveedor')->onDelete('restrict');
            $table->foreign('facturap1_tipogasto')->references('id')->on('tipogasto')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturap1');
    }
}
