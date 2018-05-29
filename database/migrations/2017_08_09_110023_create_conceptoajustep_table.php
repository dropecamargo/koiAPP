<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptoajustepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptoajustep', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('conceptoajustep_nombre', 50)->unique();
            $table->integer('conceptoajustep_cuenta')->unsigned();
            $table->boolean('conceptoajustep_activo')->default(false);

            $table->foreign('conceptoajustep_cuenta')->references('id')->on('plancuentas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptoajustep');
    }
}
