<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentocobroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentocobro', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('documentocobro_deudor')->unsigned();
            $table->string('documentocobro_tipo', 20);
            $table->string('documentocobro_numero', 20);
            $table->date('documentocobro_expedicion');
            $table->date('documentocobro_vencimiento');
            $table->integer('documentocobro_cuota');
            $table->double('documentocobro_valor')->default(0);
            $table->double('documentocobro_saldo')->default(0);

            $table->foreign('documentocobro_deudor')->references('id')->on('deudor')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentocobro');
    }
}
