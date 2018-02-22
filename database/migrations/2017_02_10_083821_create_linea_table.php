<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('linea_nombre', 50)->unique();
            $table->double('linea_margen_nivel1')->default(0);
            $table->double('linea_margen_nivel2')->default(0);
            $table->double('linea_margen_nivel3')->default(0);
            $table->boolean('linea_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('linea');
    }
}
