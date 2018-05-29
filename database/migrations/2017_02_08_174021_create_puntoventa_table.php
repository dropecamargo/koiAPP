<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntoventa', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('puntoventa_nombre', 200)->unique();
            $table->integer('puntoventa_numero')->default(0)->comment = 'Consecutivo factura';
            $table->string('puntoventa_prefijo', 4)->nullable()->unique();
            $table->string('puntoventa_resolucion_dian', 200)->nullable();
            $table->boolean('puntoventa_activo')->default(false);
            $table->string('puntoventa_footer1', 250)->nullable();
            $table->string('puntoventa_footer2', 250)->nullable();
            $table->string('puntoventa_observacion', 250)->nullable();
            $table->string('puntoventa_encabezado', 250)->nullable();
            $table->string('puntoventa_frase', 250)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntoventa');
    }
}
