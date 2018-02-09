<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierrecarteraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierrecartera', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cierrecartera_mes');
            $table->integer('cierrecartera_ano');
            $table->integer('cierrecartera_tercero')->unsigned();
            $table->integer('cierrecartera_documentos')->unsigned();
            $table->integer('cierrecartera_id')->unsigned();
            $table->date('cierrecartera_expedicion');
            $table->date('cierrecartera_vencimiento');
            $table->date('cierrecartera_corte');
            $table->double('cierrecartera_valor')->default(0);
            $table->double('cierrecartera_saldo')->default(0);
            $table->dateTime('cierrecartera_fh_creacion');

            $table->foreign('cierrecartera_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('cierrecartera_documentos')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cierrecartera');
    }
}
