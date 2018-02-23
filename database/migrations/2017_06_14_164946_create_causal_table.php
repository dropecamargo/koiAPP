<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCausalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('causal', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('causal_nombre', 100)->unique();
            $table->boolean('causal_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('causal');
    }
}
