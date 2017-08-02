<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impuesto', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('impuesto_plancuentas')->unsigned()->nullable();
            $table->string('impuesto_nombre', 100);
            $table->double('impuesto_porcentaje');
            $table->boolean('impuesto_activo')->default(0);
            
            $table->foreign('impuesto_plancuentas')->references('id')->on('plancuentas')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impuesto');
    }
}
