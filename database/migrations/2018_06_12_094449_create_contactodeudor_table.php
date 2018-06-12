<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactodeudorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactodeudor', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('contactodeudor_deudor')->unsigned();
            $table->string('contactodeudor_nombre', 200);
            $table->string('contactodeudor_direccion', 200);
            $table->string('contactodeudor_telefono', 50);
            $table->string('contactodeudor_movil', 50);
            $table->string('contactodeudor_email', 100);
            $table->string('contactodeudor_cargo', 50);

            $table->foreign('contactodeudor_deudor')->references('id')->on('deudor')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactodeudor');
    }
}
