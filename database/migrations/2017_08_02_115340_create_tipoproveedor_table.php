<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoproveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoproveedor', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tipoproveedor_nombre', 25);
            $table->integer('tipoproveedor_plancuentas')->unsigned();
            $table->boolean('tipoproveedor_activo')->default(0);

            $table->foreign('tipoproveedor_plancuentas')->references('id')->on('plancuentas')->onDelete('restrict');

            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoproveedor');
    }
}
