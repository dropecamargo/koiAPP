<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChdevueltoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chdevuelto', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('chdevuelto_chposfechado1')->unsigned();
            $table->integer('chdevuelto_tercero')->unsigned();
            $table->integer('chdevuelto_causal')->unsigned();
            $table->integer('chdevuelto_documentos')->unsigned();
            $table->date('chdevuelto_fecha');
            $table->double('chdevuelto_valor');
            $table->double('chdevuelto_saldo');
            $table->integer('chdevuelto_usuario_elaboro')->unsigned();
            $table->dateTime('chdevuelto_fh_elaboro');

            $table->foreign('chdevuelto_chposfechado1')->references('id')->on('chposfechado1')->onDelete('restrict');
            $table->foreign('chdevuelto_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('chdevuelto_causal')->references('id')->on('causal')->onDelete('restrict');
            $table->foreign('chdevuelto_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('chdevuelto_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chdevuelto');
    }
}
