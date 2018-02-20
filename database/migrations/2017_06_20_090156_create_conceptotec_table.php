<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptotecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptotec', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('conceptotec_nombre',50);
            $table->boolean('conceptotec_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptotec');
    }
}
