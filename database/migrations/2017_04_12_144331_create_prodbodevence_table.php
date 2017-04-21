<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdbodevenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodbodevence', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('prodbodevence_serie')->unsigned();
            $table->integer('prodbodevence_sucursal')->unsigned();
            $table->integer('prodbodevence_lote')->unsigned();
            $table->integer('prodbodevence_item')->unsigned();
            $table->integer('prodbodevence_cantidad')->unsigned();
            $table->integer('prodbodevence_saldo')->unsigned();
            
            $table->foreign('prodbodevence_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('prodbodevence_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('prodbodevence_lote')->references('id')->on('lote')->onDelete('restrict');
            
            $table->unique(['prodbodevence_serie', 'prodbodevence_sucursal','prodbodevence_lote','prodbodevence_item'], 'prodbodevence_lote_serie_sucursal_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodbodevence');
    }
}
