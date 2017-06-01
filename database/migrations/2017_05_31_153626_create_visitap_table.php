<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitap', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('visitap_orden')->unsigned();
            $table->integer('visitap_numero')->unsigned()->nullable();
            $table->integer('visitap_producto')->unsigned();
            $table->integer('visitap_cantidad')->unsigned();
            $table->integer('visitap_autorizado')->unsigned();
            $table->integer('visitap_enviado')->unsigned();
            $table->integer('visitap_instalado')->unsigned();
            $table->integer('visitap_devuelto')->unsigned();

            $table->foreign('visitap_orden')->references('id')->on('orden')->onDelete('restrict');
            $table->foreign('visitap_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('visitap_numero')->references('id')->on('visita')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitap');
    }
}
