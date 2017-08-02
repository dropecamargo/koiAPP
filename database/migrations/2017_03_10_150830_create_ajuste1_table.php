<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjuste1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajuste1', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('ajuste1_numero')->unsigned();
            $table->integer('ajuste1_tipoajuste')->unsigned();
            $table->integer('ajuste1_sucursal')->unsigned();
            $table->date('ajuste1_fecha');
            $table->integer('ajuste1_documentos')->unsigned();
            $table->text('ajuste1_observaciones');
            $table->integer('ajuste1_usuario_elaboro')->unsigned();
            $table->dateTime('ajuste1_fh_elaboro');
            
            $table->foreign('ajuste1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('ajuste1_tipoajuste')->references('id')->on('tipoajuste')->onDelete('restrict');
            $table->foreign('ajuste1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('ajuste1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajuste1');
    }
}
