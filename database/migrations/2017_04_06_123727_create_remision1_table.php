<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemision1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remision1', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('remision1_numero')->unsigned();
            $table->integer('remision1_tiporemision')->unsigned();
            $table->integer('remision1_sucursal')->unsigned();
            $table->integer('remision1_tercero')->unsigned();

            $table->date('remision1_fecha');
            $table->integer('remision1_documentos')->unsigned();
            $table->text('remision1_observaciones');
            $table->boolean('remision1_anulada')->default(0);

            $table->integer('remision1_usuario_elaboro')->unsigned();
            $table->date('remision1_fh_elaboro');
            $table->integer('remision1_usuario_anulo')->unsigned()->nullable();
            $table->date('remision1_fh_anulo');
            
            $table->foreign('remision1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('remision1_tiporemision')->references('id')->on('tiporemision')->onDelete('restrict');
            $table->foreign('remision1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('remision1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('remision1_usuario_anulo')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remision1');
    }
}
