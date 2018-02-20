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
        Schema::create('inventario',function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('inventario_serie')->unsigned();
            $table->integer('inventario_sucursal')->unsigned();
            $table->integer('inventario_ubicacion')->unsigned()->nullable();
            $table->integer('inventario_documentos')->unsigned();
            $table->integer('inventario_id_documento')->unsigned();
            $table->integer('inventario_entrada')->unsigned();
            $table->integer('inventario_salida')->unsigned();
            $table->integer('inventario_lote')->unsigned();
            $table->integer('inventario_rollo')->unsigned();
            $table->double('inventario_metros_entrada')->default(0);
            $table->double('inventario_metros_salida')->default(0);
            $table->double('inventario_costo')->default(0);
            $table->double('inventario_costo_promedio')->default(0);
            $table->integer('inventario_usuario_elaboro')->unsigned();
            $table->dateTime('inventario_fh_elaboro');

            $table->foreign('inventario_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('inventario_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('inventario_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('inventario_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('inventario_ubicacion')->references('id')->on('ubicacion')->onDelete('restrict');
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
