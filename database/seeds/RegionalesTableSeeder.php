<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Regional;

class RegionalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regional::create([
        		'regional_nombre' => 'CUNDINAMARCA',
        		'regional_activo' => 1
        	]);

    }
}
