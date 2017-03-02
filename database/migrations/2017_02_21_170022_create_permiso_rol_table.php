<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisoRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permiso_rol', function (Blueprint $table) {
            $table->integer('module_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permiso')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('rol')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modulo')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['module_id', 'permission_id', 'role_id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permiso_rol');
    }
}
