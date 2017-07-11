<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitio', function (Blueprint $table){
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('sitio_nombre', 25);
            $table->boolean('sitio_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sitio');
    }
}
