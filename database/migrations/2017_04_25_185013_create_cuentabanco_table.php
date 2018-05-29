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
            $table->string('cuentabanco_nombre', 50)->unique();
            $table->string('cuentabanco_numero', 25);
            $table->integer('cuentabanco_banco')->unsigned();
            $table->integer('cuentabanco_cuenta')->unsigned();
            $table->boolean('cuentabanco_activa')->default(false);

            $table->foreign('cuentabanco_banco')->references('id')->on('banco')->onDelete('restrict');
            $table->foreign('cuentabanco_cuenta')->references('id')->on('plancuentas')->onDelete('restrict');
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
