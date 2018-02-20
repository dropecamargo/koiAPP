<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoajusteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoajuste', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipoajuste_nombre',25);
            $table->string('tipoajuste_sigla',3);
            $table->string('tipoajuste_tipo',1);
            $table->boolean('tipoajuste_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoajuste');
    }
}
