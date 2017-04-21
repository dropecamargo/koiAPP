<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizaca', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('autorizaca_tercero')->unsigned();
            $table->date('autorizaca_vencimiento');
            $table->integer('autorizaca_plazo')->unsigned();
            $table->integer('autorizaca_cupo')->unsigned();
            $table->double('autorizaca_por_vencer');
            $table->double('autorizaca_30');
            $table->double('autorizaca_60');
            $table->double('autorizaca_90');
            $table->double('autorizaca_180');
            $table->double('autorizaca_360');
            $table->double('autorizaca_mas_360');
            $table->text('autorizaca_observaciones');
            $table->integer('autorizaca_usuario_aprobo')->unsigned();
            $table->datetime('autorizaca_fh_aprobo');
            
            $table->foreign('autorizaca_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('autorizaca_usuario_aprobo')->references('id')->on('tercero')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizaca');
    }
}
