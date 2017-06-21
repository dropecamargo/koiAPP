<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitai', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('visitai_orden')->unsigned();
            $table->integer('visitai_item')->unsigned();
            $table->string('visitai_archivo',100);
            $table->integer('visitai_usuario_elaboro')->unsigned();
            $table->dateTime('visitai_fh_elaboro');

            $table->foreign('visitai_orden')->references('id')->on('orden')->onDelete('restrict');
            $table->foreign('visitai_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitai');
    }
}
