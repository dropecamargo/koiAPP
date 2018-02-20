<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('producto_serie', 20)->unique();
            $table->string('producto_referencia',20);
            $table->string('producto_nombre', 100);
            $table->string('producto_ref_proveedor',20);
            $table->boolean('producto_maneja_serie')->default(false)->comment = 'El producto maneja serie';
            $table->boolean('producto_metrado')->default(false)->comment = 'El producto se va a vender por metros';
            $table->boolean('producto_vence')->default(false);
            $table->boolean('producto_unidad')->default(false);
            $table->double('producto_costo')->default(0);
            $table->double('producto_peso')->default(0);
            $table->double('producto_largo')->default(0);
            $table->double('producto_alto')->default(0);
            $table->double('producto_ancho')->default(0);
            $table->double('producto_precio1')->default(0);
            $table->double('producto_precio2')->default(0);
            $table->double('producto_precio3')->default(0);
            $table->integer('producto_vidautil')->nullable();
            $table->string('producto_barras',100);

            $table->integer('producto_marca')->unsigned();
            $table->integer('producto_modelo')->unsigned();
            $table->integer('producto_servicio')->unsigned()->nullable();
            $table->integer('producto_linea')->unsigned();
            $table->integer('producto_grupo')->unsigned();
            $table->integer('producto_subgrupo')->unsigned();
            $table->integer('producto_unidadmedida')->unsigned()->nullable();
            $table->integer('producto_impuesto')->unsigned();
            $table->integer('producto_tipoproducto')->unsigned();
            $table->integer('producto_tercero')->unsigned()->nullable();
            $table->integer('producto_contacto')->unsigned()->nullable();
            $table->date('producto_vencimiento')->nullable();

            $table->foreign('producto_marca')->references('id')->on('marca')->onDelete('restrict');
            $table->foreign('producto_modelo')->references('id')->on('modelo')->onDelete('restrict');
            $table->foreign('producto_servicio')->references('id')->on('servicio')->onDelete('restrict');
            $table->foreign('producto_linea')->references('id')->on('linea')->onDelete('restrict');
            $table->foreign('producto_grupo')->references('id')->on('grupo')->onDelete('restrict');
            $table->foreign('producto_subgrupo')->references('id')->on('subgrupo')->onDelete('restrict');
            $table->foreign('producto_unidadmedida')->references('id')->on('unidadmedida')->onDelete('restrict');
            $table->foreign('producto_impuesto')->references('id')->on('impuesto')->onDelete('restrict');
            $table->foreign('producto_tipoproducto')->references('id')->on('tipoproducto')->onDelete('restrict');
            $table->foreign('producto_tercero')->references('id')->on('tercero')->onDelete('restrict');
            $table->foreign('producto_contacto')->references('id')->on('tcontacto')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
