<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivofijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activofijo', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('activofijo_placa', 20);
            $table->string('activofijo_serie', 20);
            $table->integer('activofijo_tipoactivo')->unsigned();
            $table->text('activofijo_descripcion');
            $table->date('activofijo_compra');
            $table->date('activofijo_activacion');
            $table->double('activofijo_costo')->default(0);
            $table->double('activofijo_depreciacion')->default(0);
            $table->integer('activofijo_responsable')->unsigned();
            $table->integer('activofijo_vida_util')->unsigned();
            $table->integer('activofijo_facturap1')->unsigned();

            $table->foreign('activofijo_responsable')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('activofijo_facturap1')->references('id')->on('facturap1')->onDelete('restrict');
            $table->foreign('activofijo_tipoactivo')->references('id')->on('tipoactivo')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activofijo');
    }
}
