<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipogastoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipogasto', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipogasto_nombre', 25);
            $table->integer('tipogasto_plancuentas')->unsigned();
            $table->boolean('tipogasto_activo')->default(0);

            $table->foreign('tipogasto_plancuentas')->references('id')->on('plancuentas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipogasto');
    }
}
