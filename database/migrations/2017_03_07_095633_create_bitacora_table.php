<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('bitacora', function (Blueprint $table){
            
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('bitacora_documento')->unsigned();
            $table->integer('bitacora_documentos')->unsigned();
            $table->string('bitacora_campo',30);
            $table->text('bitacora_anterior');
            $table->text('bitacora_nuevo'); 
            $table->date('bitacora_fh_elaboro');
            $table->integer('bitacora_usuario_elaboro')->unsigned();

            $table->foreign('bitacora_documentos')->references('id')->on('documentos')->onDelete('restrict');
            $table->foreign('bitacora_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}
