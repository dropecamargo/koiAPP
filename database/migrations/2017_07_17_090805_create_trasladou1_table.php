<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrasladou1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trasladou1',function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('trasladou1_numero')->unsigned();
            $table->integer('trasladou1_sucursal')->unsigned();
            $table->integer('trasladou1_origen')->unsigned()->nullable();
            $table->integer('trasladou1_destino')->unsigned();
            $table->date('trasladou1_fecha');
            $table->integer('trasladou1_tipotraslado')->unsigned();
            $table->integer('trasladou1_documentos')->unsigned();
            $table->text('trasladou1_observaciones');
            $table->integer('trasladou1_usuario_elaboro')->unsigned();
            $table->dateTime('trasladou1_fh_elaboro');

            $table->foreign('trasladou1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('trasladou1_origen')->references('id')->on('ubicacion')->onDelete('restrict');
            $table->foreign('trasladou1_destino')->references('id')->on('ubicacion')->onDelete('restrict');
            $table->foreign('trasladou1_tipotraslado')->references('id')->on('tipotraslado')->onDelete('restrict');
            $table->foreign('trasladou1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('trasladou1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trasladou1');
    }
}
