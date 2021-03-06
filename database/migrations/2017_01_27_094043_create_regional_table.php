<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regional', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('regional_nombre', 200)->unique();
            $table->integer('regional_reci')->unsigned();
            $table->integer('regional_nota')->unsigned();
            $table->integer('regional_ord')->unsigned();
            $table->integer('regional_ajuc')->unsigned();
            $table->integer('regional_anti')->unsigned();
            $table->integer('regional_chp')->unsigned();
            $table->integer('regional_chd')->unsigned();
            $table->integer('regional_fpro')->unsigned();
            $table->integer('regional_ajup')->unsigned();
            $table->integer('regional_egre')->unsigned();
            $table->integer('regional_cm')->unsigned();
            $table->boolean('regional_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regional');
    }
}
