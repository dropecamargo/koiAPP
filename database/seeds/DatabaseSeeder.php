<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TerceroTableSeeder::class);
        $this->call(EmpresaTableSeeder::class);
        $this->call(DocumentosTableSeeder::class);
        $this->call(RegionalesTableSeeder::class);
        $this->call(SucursalesTableSeeder::class);
        $this->call(ModulosTableSeeder::class);
        $this->call(PermisosTableSeeder::class);
        $this->call(ImpuestoTableSeeder::class);
        $this->call(UnidadMedidaTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(TipoNotificacionTableSeeder::class);
        $this->call(ServicioTableSeeder::class);
        $this->call(UsuarioRolTableSeeder::class);

        Model::reguard();
    }
}
