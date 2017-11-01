<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuxreporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auxreporte', function(Blueprint $table){
            $table->engine = 'InnoDB';

            $table->string('auxreporte_varchar1', 100);
            $table->string('auxreporte_varchar2', 100);
            $table->string('auxreporte_varchar3', 100);
            $table->double('auxreporte_double0')->default(0);
            $table->double('auxreporte_double1')->default(0);
            $table->double('auxreporte_double2')->default(0);
            $table->double('auxreporte_double3')->default(0);
            $table->double('auxreporte_double4')->default(0);
            $table->double('auxreporte_double5')->default(0);
            $table->double('auxreporte_double6')->default(0);
            $table->double('auxreporte_double7')->default(0);
            $table->double('auxreporte_double8')->default(0);
            $table->double('auxreporte_double9')->default(0);
            $table->double('auxreporte_double10')->default(0);
            $table->double('auxreporte_double11')->default(0);
            $table->double('auxreporte_double12')->default(0);
            $table->double('auxreporte_double13')->default(0);
            $table->double('auxreporte_double14')->default(0);

            /* Position cantidad sucursales */
            $table->integer('auxreporte_integer1')->unsigned();
            $table->integer('auxreporte_integer2')->unsigned();
            $table->integer('auxreporte_integer3')->unsigned();
            $table->integer('auxreporte_integer4')->unsigned();
            $table->integer('auxreporte_integer5')->unsigned();
            $table->integer('auxreporte_integer6')->unsigned();
            $table->integer('auxreporte_integer7')->unsigned();
            $table->integer('auxreporte_integer8')->unsigned();
            $table->integer('auxreporte_integer9')->unsigned();
            $table->integer('auxreporte_integer10')->unsigned();
            $table->integer('auxreporte_integer11')->unsigned();
            $table->integer('auxreporte_integer12')->unsigned();
            $table->integer('auxreporte_integer13')->unsigned();
            $table->integer('auxreporte_integer14')->unsigned();
            $table->integer('auxreporte_integer15')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auxreporte');
    }
}
