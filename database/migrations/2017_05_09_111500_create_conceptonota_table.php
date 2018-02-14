<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptonotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptonota', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('conceptonota_nombre', 50);
            $table->boolean('conceptonota_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptonota');
    }
}
