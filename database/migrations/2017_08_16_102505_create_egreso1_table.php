<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgreso1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egreso1', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('egreso1_regional')->unsigned();
            $table->integer('egreso1_numero')->unsigned();
            $table->integer('egreso1_documentos')->unsigned();
            $table->integer('egreso1_tercero')->unsigned();
            $table->integer('egreso1_cuentas')->unsigned();
            $table->date('egreso1_fecha');
            $table->string('egreso1_numero_cheque',15);
            $table->date('egreso1_fecha_cheque');
            $table->double('egreso1_valor_cheque');
            $table->text('egreso1_observaciones');
            $table->integer('egreso1_usuario_elaboro')->unsigned();
            $table->dateTime('egreso1_fh_elaboro');
            $table->boolean('egreso1_anulado')->default(false);
            $table->integer('egreso1_usuario_anulo')->unsigned()->nullable();
            $table->dateTime('egreso1_fh_anulo');

            $table->foreign('egreso1_regional')->references('id')->on('regional')->onDelete('restrict');
            $table->foreign('egreso1_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('egreso1_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('egreso1_cuentas')->references('id')->on('cuentabanco')->onDelete('restrict');
            $table->foreign('egreso1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('egreso1_usuario_anulo')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egreso1');
    }
}
