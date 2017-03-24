<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('inventario_sucursal')->unsigned();
            $table->integer('inventario_producto')->unsigned();
            $table->integer('inventario_documentos')->unsigned();
            $table->integer('inventario_numero')->unsigned()->comment = 'ID documento de origen';
            $table->integer('inventario_entrada')->unsigned()->default(0);
            $table->integer('inventario_salida')->unsigned()->default(0);
            $table->integer('inventario_saldo_sucursal')->unsigned()->default(0);
            $table->integer('inventario_saldo_total')->unsigned()->default(0);  
            $table->double('inventario_costo')->unsigned()->default(0);
            $table->double('inventario_costo_promedio')->unsigned()->default(0);
            $table->integer('inventario_usuario_elaboro')->unsigned();
            $table->datetime('inventario_fecha_elaboro');

            $table->foreign('inventario_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('inventario_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('inventario_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('inventario_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario');
    }
}
