<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('notificacion_tercero')->unsigned();
            $table->integer('notificacion_tiponotificacion')->unsigned();
            $table->boolean('notificacion_visto')->default(false);
            $table->dateTime('notificacion_fh_visto')->nullable();
            $table->date('notificacion_fecha');
            $table->time('notificacion_hora')->nullable();
            $table->text('notificacion_url');
            $table->text('notificacion_descripcion');
            $table->string('notificacion_titulo', 100);

            $table->foreign('notificacion_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('notificacion_tiponotificacion')->references('id')->on('tiponotificacion')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}
