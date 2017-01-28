<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use DB, Cache;

class Municipio extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'municipio';

    public $timestamps = false;

    public static function getMunicipios()
    {
        if (Cache::has('_municipios')) {
            return Cache::get('_municipios');    
        }

        return Cache::rememberForever('_municipios', function() {
            $query = Municipio::query();
            $query->select('municipio.id', DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"));
            $query->join('departamento', 'municipio.departamento_codigo', '=', 'departamento.departamento_codigo');
            $query->orderby('municipio_nombre', 'asc');
            $collection = $query->lists('municipio_nombre', 'municipio.id');
            
            $collection->prepend('', '');
            return $collection;
        });
    }
}
