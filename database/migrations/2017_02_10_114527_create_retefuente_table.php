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
            $table->string('retefuente_nombre', 100)->unique();
            $table->double('retefuente_base')->default(0);
            $table->double('retefuente_tarifa_no_declarate_natural')->default(0);
            $table->double('retefuente_tarifa_declarante_natural')->default(0);
            $table->double('retefuente_tarifa_juridico')->default(0);
            $table->boolean('retefuente_activo')->default(false);
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
