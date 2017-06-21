<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visita', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('visita_orden')->unsigned();
            $table->integer('visita_tecnico')->unsigned();
            $table->integer('visita_numero')->unsigned();
            $table->dateTime('visita_fh_llegada');
            $table->dateTime('visita_fh_inicio');
            $table->dateTime('visita_fh_finaliza');
            $table->integer('visita_tiempo_transporte')->unsigned();
            $table->double('visita_viaticos')->default(0);
            $table->double('visita_cierra')->default(0);
            $table->text('visita_observaciones');
            $table->integer('visita_usuario_elaboro')->unsigned();
            $table->dateTime('visita_fh_elaboro');

            $table->foreign('visita_orden')->references('id')->on('orden')->onDelete('restrict');
            $table->foreign('visita_tecnico')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('visita_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visita');
    }
}
