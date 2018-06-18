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
            $table->integer('linea_cuenta')->unsigned();

            $table->foreign('linea_cuenta')->references('id')->on('plancuentas')->onDelete('restrict');
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
