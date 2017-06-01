<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->date('orden_fecha');
            $table->integer('orden_tercero')->unsigned();
            $table->integer('orden_placa')->unsigned(); 
            $table->integer('orden_tipoorden')->unsigned();
            $table->integer('orden_solicitante')->unsigned();
           
            $table->integer('orden_tecnico')->unsigned();
            $table->dateTime('orden_fh_servicio');
            $table->datetime('orden_fecha_elaboro');
            $table->integer('orden_usuario_elaboro')->unsigned();

            $table->string('orden_persona',100);
            $table->integer('orden_dano')->unsigned();
            $table->integer('orden_prioridad')->unsigned();
            $table->text('orden_problema');
            $table->boolean('orden_abierta')->default(true);

            $table->foreign('orden_placa')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('orden_tipoorden')->references('id')->on('tipoorden')->onDelete('restrict');
            $table->foreign('orden_solicitante')->references('id')->on('solicitante')->onDelete('restrict');
            $table->foreign('orden_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('orden_tecnico')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('orden_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');

            $table->foreign('orden_dano')->references('id')->on('dano')->onDelete('restrict');
            $table->foreign('orden_prioridad')->references('id')->on('prioridad')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden');
    }
}
