<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productoi', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('productoi_producto')->unsigned();
            $table->string('productoi_archivo', 200);
            $table->datetime('productoi_fh_elaboro');
            $table->integer('productoi_usuario_elaboro')->unsigned();

            $table->foreign('productoi_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('productoi_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productoi');
    }
}
