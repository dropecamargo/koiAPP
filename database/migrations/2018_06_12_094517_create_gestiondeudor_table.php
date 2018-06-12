<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestiondeudorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestiondeudor', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('gestiondeudor_deudor')->unsigned();
            $table->dateTime('gestiondeudor_fh');
            $table->text('gestiondeudor_observaciones');
            $table->integer('gestiondeudor_conceptocob');
            $table->dateTime('gestiondeudor_proxima');
            $table->integer('gestiondeudor_usuario_elaboro')->unsigned();
            $table->dateTime('gestiondeudor_fh_elaboro');

            $table->foreign('gestiondeudor_deudor')->references('id')->on('deudor')->onDelete('restrict');
            $table->foreign('gestiondeudor_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestiondeudor');
    }
}
