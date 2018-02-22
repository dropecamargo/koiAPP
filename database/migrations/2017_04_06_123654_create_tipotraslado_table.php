<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipotrasladoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipotraslado', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipotraslado_nombre', 25);
            $table->string('tipotraslado_sigla', 3);
            $table->boolean('tipotraslado_activo')->default(true);

            $table->unique(['tipotraslado_nombre', 'tipotraslado_sigla']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipotraslado');
    }
}
