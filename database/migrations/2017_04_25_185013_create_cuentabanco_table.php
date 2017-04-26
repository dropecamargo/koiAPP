<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentabancoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentabanco', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('cuentabanco_nombre', 50);
            $table->string('cuentabanco_numero', 25);
            $table->integer('cuentabanco_plancuentas')->unsigned()->nullable();
            $table->integer('cuentabanco_banco')->unsigned()->nullable();
            $table->boolean('cuentabanco_activa')->default(false);

            $table->foreign('cuentabanco_plancuentas')->references('id')->on('plancuentas')->onDelete('restrict');
            $table->foreign('cuentabanco_banco')->references('id')->on('banco')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentabanco');
    }
}
