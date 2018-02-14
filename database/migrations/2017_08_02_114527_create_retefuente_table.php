<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetefuenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retefuente', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('retefuente_nombre',50);
            $table->double('retefuente_base');
            $table->double('retefuente_tarifa_natural');
            $table->double('retefuente_tarifa_juridico');
            $table->boolean('retefuente_activo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retefuente');
    }
}
