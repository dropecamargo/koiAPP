<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChposfechado1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chposfechado1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('chposfechado1_sucursal')->unsigned();
            $table->integer('chposfechado1_numero')->unsigned();
            $table->date('chposfechado1_fecha');
            $table->integer('chposfechado1_documentos')->unsigned();
            $table->integer('chposfechado1_tercero')->unsigned();
            $table->string('chposfechado1_ch_numero',25);
            $table->date('chposfechado1_ch_fecha');
            $table->integer('chposfechado1_banco')->unsigned();
            $table->string('chposfechado1_girador',100);
            $table->boolean('chposfechado1_central_riesgo')->default(false);
            $table->boolean('chposfechado1_activo')->default(false);
            $table->boolean('chposfechado1_anulado')->default(false);
            $table->boolean('chposfechado1_devuelto')->default(false);
            $table->double('chposfechado1_valor')->default(0);
            $table->text('chposfechado1_observaciones');
            $table->integer('chposfechado1_usuario_elaboro')->unsigned();
            $table->dateTime('chposfechado1_fh_elaboro');
            $table->integer('chposfechado1_usuario_anulo')->unsigned()->nullable();
            $table->dateTime('chposfechado1_fh_anulo');

            $table->foreign('chposfechado1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('chposfechado1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('chposfechado1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('chposfechado1_banco')->references('id')->on('banco')->onDelete('restrict');
            $table->foreign('chposfechado1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('chposfechado1_usuario_anulo')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chposfechado1');
    }
}
