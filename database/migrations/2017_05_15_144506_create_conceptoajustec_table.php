<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptoajustecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptoajustec', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('conceptoajustec_nombre',25);
            $table->integer('conceptoajustec_plancuentas')->unsigned();
            $table->boolean('conceptoajustec_sumas_iguales')->default(false);
            $table->boolean('conceptoajustec_activo')->default(false);

            $table->foreign('conceptoajustec_plancuentas')->references('id')->on('plancuentas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptoajustec');
    }
}
