<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestioncobroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestioncobro', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('gestioncobro_tercero')->unsigned();
            $table->integer('gestioncobro_conceptocob')->unsigned();
            $table->dateTime('gestioncobro_proxima');
            $table->dateTime('gestioncobro_fh');
            $table->text('gestioncobro_observaciones');
            $table->integer('gestioncobro_usuario_elaboro')->unsigned();
            $table->dateTime('gestioncobro_fh_elaboro');

            $table->foreign('gestioncobro_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('gestioncobro_conceptocob')->references('id')->on('conceptocob')->onDelete('restrict');
            $table->foreign('gestioncobro_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestioncobro');
    }
}
