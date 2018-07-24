<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursaliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursali', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('sucursali_sucursal')->unsigned();
            $table->string('sucursali_archivo', 200);
            $table->datetime('sucursali_fh_elaboro');
            $table->integer('sucursali_usuario_elaboro')->unsigned();

            $table->foreign('sucursali_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('sucursali_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sucursali');
    }
}
