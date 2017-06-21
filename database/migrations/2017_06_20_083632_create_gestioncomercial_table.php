<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestioncomercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestioncomercial', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('gestioncomercial_tercero')->unsigned();
            $table->integer('gestioncomercial_vendedor')->unsigned();
            $table->datetime('gestioncomercial_fh');
            $table->text('gestioncomercial_observaciones');
            $table->integer('gestioncomercial_conceptocom')->unsigned();
            $table->datetime('gestioncomercial_inicio');
            $table->datetime('gestioncomercial_finalizo');
            $table->integer('gestioncomercial_usuario_elaboro')->unsigned();
            $table->datetime('gestioncomercial_fh_elaboro');

            $table->foreign('gestioncomercial_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('gestioncomercial_vendedor')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('gestioncomercial_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('gestioncomercial_conceptocom')->references('id')->on('conceptocom')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestioncomercial');
    }
}
