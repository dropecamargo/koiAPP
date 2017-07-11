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
            $table->integer('orden_documentos')->unsigned();
            $table->integer('orden_sucursal')->unsigned();
            $table->integer('orden_numero')->unsigned();
            $table->integer('orden_tercero')->unsigned();
            $table->integer('orden_serie')->unsigned()->nullable();
            $table->integer('orden_contacto')->unsigned();
            $table->integer('orden_sitio')->unsigned();
            $table->integer('orden_tipoorden')->unsigned();
            $table->integer('orden_solicitante')->unsigned();
            $table->integer('orden_tecnico')->unsigned();
            $table->dateTime('orden_fh_servicio');
            $table->string('orden_llamo',100);
            $table->integer('orden_dano')->unsigned();
            $table->integer('orden_prioridad')->unsigned();
            $table->text('orden_problema');
            $table->boolean('orden_abierta')->default(true);
            $table->integer('orden_usuario_elaboro')->unsigned();
            $table->datetime('orden_fh_elaboro');
            $table->integer('orden_usuario_cerro')->unsigned()->nullable();
            $table->datetime('orden_fh_cerro');

            $table->foreign('orden_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('orden_serie')->references('id')->on('producto')->onDelete('restrict');
            $table->foreign('orden_tipoorden')->references('id')->on('tipoorden')->onDelete('restrict');
            $table->foreign('orden_solicitante')->references('id')->on('solicitante')->onDelete('restrict');
            $table->foreign('orden_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('orden_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('orden_tecnico')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('orden_dano')->references('id')->on('dano')->onDelete('restrict');
            $table->foreign('orden_contacto')->references('id')->on('tcontacto')->onDelete('restrict');
            $table->foreign('orden_sitio')->references('id')->on('sitio')->onDelete('restrict');
            $table->foreign('orden_prioridad')->references('id')->on('prioridad')->onDelete('restrict');
            $table->foreign('orden_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('orden_usuario_cerro')->references('id')->on('tercero')->onDelete('restrict');
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
