<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptocajamenorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptocajamenor', function (Blueprint $table){

            $table->engine = "InnoDB";
            $table->increments('id');

            $table->string('conceptocajamenor_nombre', 50)->unique();
            $table->integer('conceptocajamenor_administrativo')->unsigned();
            $table->integer('conceptocajamenor_ventas')->unsigned();
            $table->boolean('conceptocajamenor_activo')->default(false);

            $table->foreign('conceptocajamenor_administrativo')->references('id')->on('plancuentas')->onDelete('restrict');
            $table->foreign('conceptocajamenor_ventas')->references('id')->on('plancuentas')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptocajamenor');
    }
}
