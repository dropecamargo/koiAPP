<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemrepuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remrepu', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('remrepu_orden')->unsigned();
            $table->integer('remrepu_sucursal')->unsigned();
            $table->integer('remrepu_numero')->unsigned();
            $table->integer('remrepu_documentos')->unsigned();
            $table->integer('remrepu_facturado')->unsigned();
            $table->integer('remrepu_producto')->unsigned();
            $table->integer('remrepu_cantidad')->unsigned();
            $table->integer('remrepu_autorizado')->unsigned();
            $table->integer('remrepu_enviado')->unsigned();
            $table->integer('remrepu_instalado')->unsigned();
            $table->integer('remrepu_devuelto')->unsigned();

            $table->foreign('remrepu_orden')->references('id')->on('orden')->onDelete('restrict');
            $table->foreign('remrepu_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('remrepu_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('remrepu_producto')->references('id')->on('producto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remrepu');
    }
}
