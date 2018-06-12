<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('documentos_codigo', 4)->unique();
            $table->string('documentos_nombre', 25);
            $table->boolean('documentos_cartera')->default(false);
            $table->boolean('documentos_contabilidad')->default(false);
            $table->boolean('documentos_comercial')->default(false);
            $table->boolean('documentos_inventario')->default(false);
            $table->boolean('documentos_tecnico')->default(false);
            $table->boolean('documentos_tesoreria')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
