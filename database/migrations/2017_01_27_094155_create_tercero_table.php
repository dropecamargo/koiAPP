<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerceroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tercero', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tercero_nit', 15)->unique();
            $table->integer('tercero_digito')->default(0);
            $table->string('tercero_tipo', 2)->nullable();
            $table->integer('tercero_regimen')->nullable();
            $table->string('tercero_persona', 1)->nullable();

            $table->string('tercero_nombre1', 100)->nullable();
            $table->string('tercero_nombre2', 100)->nullable();
            $table->string('tercero_apellido1', 100)->nullable();
            $table->string('tercero_apellido2', 100)->nullable();
            $table->string('tercero_razonsocial', 200)->nullable();
            $table->string('tercero_direccion', 200)->nullable();
            $table->string('tercero_dir_nomenclatura', 200)->nullable();
            $table->string('tercero_postal', 100)->nullable();
            $table->integer('tercero_municipio')->unsigned()->nullable();
            $table->integer('tercero_pais')->unsigned()->nullable();
            $table->string('tercero_familia',10)->nullable();
            $table->string('tercero_email', 200)->nullable();

            $table->string('tercero_telefono1', 30)->nullable();
            $table->string('tercero_telefono2', 30)->nullable();
            $table->string('tercero_fax', 30)->nullable();
            $table->string('tercero_celular', 30)->nullable();

            $table->integer('tercero_actividad')->unsigned()->nullable();
            $table->string('tercero_cc_representante', 15)->nullable();
            $table->string('tercero_representante', 200)->nullable();

            $table->boolean('tercero_activo')->default(false);
            $table->boolean('tercero_responsable_iva')->default(false);
            $table->boolean('tercero_autoretenedor_cree')->default(false);
            $table->boolean('tercero_gran_contribuyente')->default(false);
            $table->boolean('tercero_autoretenedor_renta')->default(false);
            $table->boolean('tercero_autoretenedor_ica')->default(false);
            $table->boolean('tercero_socio')->default(false);
            $table->boolean('tercero_cliente')->default(false);
            $table->boolean('tercero_acreedor')->default(false);
            $table->boolean('tercero_interno')->default(false);
            $table->boolean('tercero_mandatario')->default(false);
            $table->boolean('tercero_empleado')->default(false);
            $table->boolean('tercero_proveedor')->default(false);
            $table->boolean('tercero_extranjero')->default(false);
            $table->boolean('tercero_afiliado')->default(false);
            $table->boolean('tercero_tecnico')->default(false);
            $table->boolean('tercero_coordinador')->default(false);
            $table->boolean('tercero_vendedor')->default(false);
            $table->boolean('tercero_otro')->default(false);
            $table->string('tercero_cual', 200)->nullable();
            $table->integer('tercero_coordinador_por')->unsigned()->nullable();
            $table->integer('tercero_sucursal')->unsigned()->nullable();

            $table->string('username')->unique()->nullable();
            $table->string('password', 60);

            $table->foreign('tercero_municipio')->references('id')->on('municipio')->onDelete('restrict');
            $table->foreign('tercero_pais')->references('id')->on('pais')->onDelete('restrict');
            $table->foreign('tercero_actividad')->references('id')->on('actividad')->onDelete('restrict');
            $table->foreign('tercero_sucursal')->references('id')->on('sucursal')->onDelete('restrict');
            $table->foreign('tercero_coordinador_por')->references('id')->on('tercero')->onDelete('restrict');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tercero');
    }
}
