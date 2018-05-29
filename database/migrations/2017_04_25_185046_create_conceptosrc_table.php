<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosrcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptosrc', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('conceptosrc_nombre', 50)->unique();
            $table->integer('conceptosrc_documentos')->unsigned()->nullable();
            $table->integer('conceptosrc_cuenta')->unsigned();
            $table->boolean('conceptosrc_activo')->default(false);

            $table->foreign('conceptosrc_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('conceptosrc_cuenta')->references('id')->on('plancuentas')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptosrc');
    }
}
