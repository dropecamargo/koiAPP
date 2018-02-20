<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipopagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipopago', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipopago_nombre',25);
            $table->integer('tipopago_documentos')->unsigned()->nullable();
            $table->boolean('tipopago_activo')->default(false);

            $table->foreign('tipopago_documentos')->references('id')->on('documentos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipopago');
    }
}
