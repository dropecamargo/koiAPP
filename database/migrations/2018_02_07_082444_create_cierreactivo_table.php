<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCierreactivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierreactivo', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('cierreactivo_mes');
            $table->integer('cierreactivo_ano');
            $table->integer('cierreactivo_activotijo')->unsigned();
            $table->integer('cierreactivo_tipoactivo')->unsigned();
            $table->integer('cierreactivo_responsable')->unsigned();
            $table->double('cierreactivo_costo')->default(0);
            $table->double('cierreactivo_depreciacion')->default(0);
            $table->dateTime('cierreactivo_fh_elaboro');

            $table->foreign('cierreactivo_activotijo')->references('id')->on('activofijo')->onDelete('restrict');
            $table->foreign('cierreactivo_tipoactivo')->references('id')->on('tipoactivo')->onDelete('restrict');
            $table->foreign('cierreactivo_responsable')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cierreactivo');
    }
}
