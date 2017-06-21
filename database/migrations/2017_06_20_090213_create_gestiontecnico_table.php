<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestiontecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestiontecnico', function( Blueprint $table ){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('gestiontecnico_tercero')->unsigned();
            $table->integer('gestiontecnico_tecnico')->unsigned();
            $table->datetime('gestiontecnico_fh');
            $table->text('gestiontecnico_observaciones');
            $table->integer('gestiontecnico_conceptotec')->unsigned();
            $table->datetime('gestiontecnico_inicio');
            $table->datetime('gestiontecnico_finalizo');
            $table->integer('gestiontecnico_usuario_elaboro')->unsigned();
            $table->datetime('gestiontecnico_fh_elaboro');

            $table->foreign('gestiontecnico_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('gestiontecnico_tecnico')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('gestiontecnico_conceptotec')->references('id')->on('conceptotec')->onDelete('restrict');
            $table->foreign('gestiontecnico_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestiontecnico');
    }
}
