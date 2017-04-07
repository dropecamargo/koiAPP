<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiporemisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiporemision', function (Blueprint $table){
            
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tiporemision_nombre',25);
            $table->string('tiporemision_sigla',3);
            $table->boolean('tiporemision_activio')->default(true);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiporemision');   
    }
}
