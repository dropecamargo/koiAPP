<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Rol;

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
            'name'   => 'admin',
            'display_name'   => 'Administrador',
            'description'   => ':V',
        ]);

    	Rol::create([
	    	'name' => 'logistic',
	    	'display_name' => 'Logistica',
	    	'description' => 'Perfil logistica plataforma'
    	]);
    }
}
