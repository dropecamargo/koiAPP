<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediopagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediopago', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('mediopago_nombre', 25);
            $table->boolean('mediopago_activo')->default(false);
            $table->boolean('mediopago_ch')->default(false);
            $table->boolean('mediopago_ef')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mediopago');
    }
}
