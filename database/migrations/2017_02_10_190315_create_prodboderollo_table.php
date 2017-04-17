<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdboderolloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodboderollo', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('prodboderollo_serie')->unsigned();
            $table->integer('prodboderollo_sucursal')->unsigned();
            $table->integer('prodboderollo_lote')->unsigned();
            $table->integer('prodboderollo_item')->unsigned();
            $table->double('prodboderollo_metros')->default(0);
            $table->double('prodboderollo_saldo')->default(0);
            $table->double('prodboderollo_costo')->default(0)->comment = 'Costo por metro (Costo total del rollo / # metros)';

            $table->foreign('prodboderollo_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('prodboderollo_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('prodboderollo_lote')->references('id')->on('lote')->onDelete('restrict');
            
            $table->unique(['prodboderollo_serie', 'prodboderollo_sucursal', 'prodboderollo_item','prodboderollo_lote'], 'prodboderollo_lote_serie_sucursal_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodboderollo');
    }
}
