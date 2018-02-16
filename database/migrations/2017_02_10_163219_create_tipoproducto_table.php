<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoproductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoproducto', function (Blueprint $table){
            $table->engine = "InnoDB";
            
            $table->increments('id');
            $table->string('tipoproducto_codigo', 2)->unique();
            $table->string('tipoproducto_nombre', 200);
            $table->boolean('tipoproducto_activo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoproducto');
    }
}
