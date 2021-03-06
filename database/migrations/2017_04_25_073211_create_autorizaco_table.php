<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizaco', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('autorizaco_numero',40);
            $table->integer('autorizaco_pedidoc2')->unsigned();
            $table->integer('autorizaco_linea')->unsigned();
            $table->integer('autorizaco_producto')->unsigned();
            $table->integer('autorizaco_margen1')->unsigned();
            $table->integer('autorizaco_margen2')->unsigned();
            $table->integer('autorizaco_margen3')->unsigned();
            $table->date('autorizaco_vencimiento');
            $table->text('autorizaco_observaciones');
            $table->integer('autorizaco_usuario_aprobo')->unsigned();
            $table->datetime('autorizaco_fh_aprobo');

            $table->foreign('autorizaco_pedidoc2')->references('id')->on('pedidoc2')->onDelete('restrict');
            $table->foreign('autorizaco_linea')->references('id')->on('linea')->onDelete('restrict');
            $table->foreign('autorizaco_producto')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('autorizaco_usuario_aprobo')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizaco');
    }
}
