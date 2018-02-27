<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventario\Linea;
use DB, Validator;

class ConfigSabanaVenta extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'configsabanaventa';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['configsabanaventa_agrupacion_nombre', 'configsabanaventa_grupo_nombre', 'configsabanaventa_unificacion_nombre'];

    public function isValid($data)
    {
        $rules = [
            'configsabanaventa_agrupacion_nombre' => 'max:50',
            'configsabanaventa_grupo_nombre' => 'max:50',
            'configsabanaventa_unificacion_nombre' => 'max:50'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    /**
    * Save configuracion de agrupación
    */
    public function getAgrupacion($id = null){
        if (is_null($id)) {
            $query = ConfigSabanaVenta::select('id');
            $query->groupBy('configsabanaventa_agrupacion', 'configsabanaventa_agrupacion_nombre');
            $agrupacion = $query->get();
            $this->configsabanaventa_agrupacion = 1 + count($agrupacion);
            $this->configsabanaventa_orden_impresion = 1 + count($agrupacion);
        }else{
            // Recupero id agrupacion
            $agrupacion = ConfigSabanaVenta::where('configsabanaventa_agrupacion',$id);
            $agrupacion->groupBy('configsabanaventa_agrupacion');
            $agrupacion = $agrupacion->first();
            if (!$agrupacion instanceof ConfigSabanaVenta) {
                return false;
            }
            $this->configsabanaventa_agrupacion = $agrupacion->configsabanaventa_agrupacion;
            $this->configsabanaventa_agrupacion_nombre = $agrupacion->configsabanaventa_agrupacion_nombre;
            $this->configsabanaventa_orden_impresion = $agrupacion->configsabanaventa_orden_impresion;
            return true;
        }
    }
    /**
    * Save configuracion de grupo
    */
    public function getGrupo($id = null){
        if (is_null($id)) {
            $query = ConfigSabanaVenta::select('id');
            $query->groupBy('configsabanaventa_grupo', 'configsabanaventa_grupo_nombre');
            $grupo = $query->get();
            $this->configsabanaventa_grupo = 1 + count($grupo);
        }else{
            // Recupero id agrupacion
            $grupo = ConfigSabanaVenta::where('configsabanaventa_grupo', $id);
            $grupo->groupBy('configsabanaventa_grupo');
            $grupo = $grupo->first();
            if (!$grupo instanceof ConfigSabanaVenta) {
                return false;
            }
            $this->configsabanaventa_grupo = $grupo->configsabanaventa_grupo;
            $this->configsabanaventa_grupo_nombre = $grupo->configsabanaventa_grupo_nombre;
            return true;
        }
    }
    /**
    * Save configuracion de unificación
    */
    public function getUnificacion($id = null){
        if (is_null($id)) {
            $query = ConfigSabanaVenta::select('id');
            $query->groupBy('configsabanaventa_unificacion', 'configsabanaventa_unificacion_nombre');
            $unificacion = $query->get();
            $this->configsabanaventa_unificacion = 1 + count($unificacion);
        }else{
            // Recupero id agrupacion
            $unificacion = ConfigSabanaVenta::where('configsabanaventa_unificacion', $id);
            $unificacion->groupBy('configsabanaventa_unificacion');
            $unificacion = $unificacion->first();
            if (!$unificacion instanceof ConfigSabanaVenta) {
                return false;
            }
            $this->configsabanaventa_unificacion = $unificacion->configsabanaventa_unificacion;
            $this->configsabanaventa_unificacion_nombre = $unificacion->configsabanaventa_unificacion_nombre;
            return true;
        }
    }
    /**
    * Get lines that can be used
    */
    public static function getLines(){
        $sql = "SELECT linea_nombre, linea.id FROM linea WHERE linea.id NOT IN (SELECT configsabanaventa_linea FROM configsabanaventa )";
        $query = DB::select($sql);
        if (empty($query)) {
            $sql = "SELECT linea_nombre, id FROM linea WHERE linea_activo = true";
            $query = DB::select($sql);
        }
        return $query;
    }
    /**
    * Get agrupaciones
    */
    public static function getAgrupaciones(){
        $query = ConfigSabanaVenta::query();
        $query->select('configsabanaventa_agrupacion_nombre', 'configsabanaventa_agrupacion');
        $query->groupBy('configsabanaventa_orden_impresion');
        $collection = $query->lists('configsabanaventa_agrupacion_nombre', 'configsabanaventa_agrupacion');
        $collection->prepend('', '');
        return $collection;
    }
    /**
    * Get grupos
    */
    public static function getGrupos($id){
        $query = ConfigSabanaVenta::query();
        $query->select('configsabanaventa_grupo_nombre AS text', 'configsabanaventa_grupo AS id');
        $query->where('configsabanaventa_agrupacion', $id);
        $query->groupBy('configsabanaventa_grupo', 'configsabanaventa_grupo_nombre');
        return $query;
    }
    /**
    * Get unificaciones
    */
    public static function getUnificaciones($id){
        $query = ConfigSabanaVenta::query();
        $query->select('configsabanaventa_unificacion_nombre AS text', 'configsabanaventa_unificacion AS id');
        $query->where('configsabanaventa_agrupacion', $id);
        $query->groupBy('configsabanaventa_unificacion', 'configsabanaventa_unificacion_nombre');
        return $query;
    }
}
