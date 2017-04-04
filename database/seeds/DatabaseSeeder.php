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
        $this->call(DepartamentoTableSeeder::class);
        $this->call(MunicipioTableSeeder::class);
        $this->call(ContactoTableSeeder::class);
        $this->call(EmpresaTableSeeder::class);
        $this->call(DocumentosTableSeeder::class);
        $this->call(RegionalesTableSeeder::class);
        $this->call(SucursalesTableSeeder::class);

        Model::reguard();
    }
}
