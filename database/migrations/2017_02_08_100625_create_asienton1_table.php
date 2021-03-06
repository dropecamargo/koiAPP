<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsienton1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asienton1', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('asienton1_ano');
            $table->integer('asienton1_asiento')->unsigned()->nullable();
            $table->integer('asienton1_mes');
            $table->integer('asienton1_folder')->unsigned();
            $table->integer('asienton1_documento')->unsigned();
            $table->integer('asienton1_numero');
            $table->integer('asienton1_dia');
            $table->string('asienton1_documentos', 4)->nullable();
            $table->integer('asienton1_id_documentos')->nullable()->unsigned();
            $table->integer('asienton1_beneficiario')->unsigned();
            $table->integer('asienton1_sucursal')->unsigned()->nullable();
            $table->boolean('asienton1_preguardado')->default(false);
            $table->text('asienton1_detalle')->nullable();
            $table->integer('asienton1_usuario_elaboro')->unsigned();
            $table->datetime('asienton1_fecha_elaboro');

            $table->foreign('asienton1_asiento')->references('id')->on('asiento1')->onDelete('restrict');
            $table->foreign('asienton1_documento')->references('id')->on('documento')->onDelete('restrict');
            $table->foreign('asienton1_beneficiario')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('asienton1_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('asienton1_folder')->references('id')->on('folder')->onDelete('restrict');
            $table->foreign('asienton1_usuario_elaboro')->references('id')->on('tercero')->onDelete('restrict');

            $table->unique(['asienton1_mes', 'asienton1_ano', 'asienton1_folder', 'asienton1_documento', 'asienton1_numero'], 'asienton1_mes_ano_folder_documento_numero_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asienton1');
    }
}
