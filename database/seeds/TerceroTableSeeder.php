<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Tercero;

class TerceroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tercero::create([
            'tercero_nit' => 1023878024,
            'tercero_tipo' => 'CC',
            'tercero_regimen' => 1,
            'tercero_persona' => 'N',
            'tercero_nombre1' => 'Pedro',
            'tercero_nombre2' => 'Antonio',
            'tercero_apellido1' => 'Camargo',
            'tercero_apellido2' => 'Jimenez',
            'tercero_activo' => true,
            'tercero_interno' => true,
            'tercero_cliente' => true,
            'tercero_vendedor' => false,
            'tercero_interno' => true,
            'tercero_email' => 'dropecamargo@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        Tercero::create([
            'tercero_nit' => 1016089425,
            'tercero_tipo' => 'CC',
            'tercero_regimen' => 1,
            'tercero_persona' => 'N',
            'tercero_nombre1' => 'Cristian',
            'tercero_nombre2' => 'Camilo',
            'tercero_apellido1' => 'Machado',
            'tercero_apellido2' => 'Bautista',
            'tercero_activo' => true,
            'tercero_interno' => true,
            'tercero_cliente' => false,
            'tercero_vendedor' => false,
            'tercero_email' => str_random(10).'@gmail.com',
            'username' => 'machadoo00',
            'password' => bcrypt('123321')
        ]);

        Tercero::create([
            'tercero_nit' => 1019120163,
            'tercero_tipo' => 'CC',
            'tercero_regimen' => 1,
            'tercero_persona' => 'N',
            'tercero_nombre1' => 'Daniel',
            'tercero_nombre2' => '',
            'tercero_apellido1' => 'Tellez',
            'tercero_apellido2' => 'Rodriguez',
            'tercero_activo' => true,
            'tercero_interno' => true,
            'tercero_cliente' => false,
            'tercero_vendedor' => false,
            'tercero_coordinador' => true,
            'tercero_email' => str_random(10).'@gmail.com',
            'username' => 'daniel',
            'password' => bcrypt('123')
        ]);
    }
 }
