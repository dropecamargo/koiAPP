<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeudorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deudor', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('deudor_tercero')->unsigned();
            $table->string('deudor_nit', 15);
            $table->integer('deudor_digito');
            $table->string('deudor_razonsocial', 200)->nullable();
            $table->string('deudor_nombre1', 100)->nullable();
            $table->string('deudor_nombre2', 100)->nullable();
            $table->string('deudor_apellido1', 100)->nullable();
            $table->string('deudor_apellido2', 100)->nullable();

            $table->foreign('deudor_tercero')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deudor');
    }
}
