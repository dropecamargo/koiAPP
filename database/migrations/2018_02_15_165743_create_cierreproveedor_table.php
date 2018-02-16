<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierreproveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierreproveedor', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('cierreproveedor_mes')->unsigned();
            $table->integer('cierreproveedor_ano')->unsigned();
            $table->integer('cierreproveedor_tercero')->unsigned();
            $table->integer('cierreproveedor_documentos')->unsigned();
            $table->integer('cierreproveedor_id')->unsigned();
            $table->date('cierreproveedor_expedicion');
            $table->date('cierreproveedor_vencimiento');
            $table->date('cierreproveedor_corte');
            $table->double('cierreproveedor_valor')->default(0);
            $table->double('cierreproveedor_saldo')->default(0);
            $table->dateTime('cierreproveedor_fh_elaboro');

            $table->foreign('cierreproveedor_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('cierreproveedor_documentos')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cierreproveedor');
    }
}
