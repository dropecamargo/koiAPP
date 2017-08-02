<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemrepu1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remrepu1', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('remrepu1_orden')->unsigned();
            $table->integer('remrepu1_sucursal')->unsigned();
            $table->integer('remrepu1_tecnico')->unsigned();
            $table->integer('remrepu1_numero')->unsigned();
            $table->integer('remrepu1_documentos')->unsigned();
            $table->integer('remrepu1_usuario_elaboro')->unsigned();
            $table->string('remrepu1_tipo', 1);
            $table->dateTime('remrepu1_fh_elaboro');

            $table->foreign('remrepu1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('remrepu1_tecnico')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('remrepu1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('remrepu1_orden')->references('id')->on('orden')->onDelete('restrict');
            $table->foreign('remrepu1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remrepu1');
    }
}
