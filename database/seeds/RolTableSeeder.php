<?php

use Illuminate\Database\Seeder;

use App\Models\Base\Rol, App\Models\Base\UsuarioRol;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Rol::create([
	    	'name' => 'admin',
	    	'display_name' => 'Administrador',
	    	'description' => 'Perfil administrador plataforma'
    	]);

    	UsuarioRol::create([
	    	'user_id' => 1,
	    	'role_id' => 1
    	]);
    }
}