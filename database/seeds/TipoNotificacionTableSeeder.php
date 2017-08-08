<?php

use Illuminate\Database\Seeder;
use App\Models\Base\TipoNotificacion;

class TipoNotificacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoNotificacion::create([
            'tiponotificacion_nombre' => 'llamada',
        ]);
    }
}
