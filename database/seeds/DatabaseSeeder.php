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
        // $this->call(DepartamentoTableSeeder::class);
        // $this->call(MunicipioTableSeeder::class);
        // $this->call(ContactoTableSeeder::class);
        $this->call(EmpresaTableSeeder::class);
        $this->call(DocumentosTableSeeder::class);
        // $this->call(RegionalesTableSeeder::class);
        // $this->call(SucursalesTableSeeder::class);
        // $this->call(MarcaTableSeeder::class);
        // $this->call(ModeloTableSeeder::class);
        // $this->call(UnidadNegocioTableSeeder::class);
        // $this->call(LineaTableSeeder::class);
        // $this->call(CategoriaTableSeeder::class);
        $this->call(ModulosTableSeeder::class);
        $this->call(PermisosTableSeeder::class);
        // $this->call(SubCategoriaTableSeeder::class);
        // $this->call(ImpuestoTableSeeder::class);
        // $this->call(UnidadMedidaTableSeeder::class);
        // $this->call(ProductoTableSeeder::class);

        Model::reguard();
    }
}
