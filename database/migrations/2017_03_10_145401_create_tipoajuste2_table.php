<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoajuste2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoajuste2', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('tipoajuste2_tipoajuste')->unsigned();
            $table->integer('tipoajuste2_tipoproducto')->unsigned();

            $table->foreign('tipoajuste2_tipoajuste')->references('id')->on('tipoajuste')->onDelete('restrict');
            $table->foreign('tipoajuste2_tipoproducto')->references('id')->on('tipoproducto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoajuste2');
    }
}
