<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnico\RemRepu2;
use Validator, DB;

class RemRepu extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'remrepu1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static $default_document = 'REMR';

    public function isValid($data)
    {
        $rules = [];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese productos para realizar la remisión de forma correcta.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    
    // Use en export.pdf
    public static function getRemision($orden)
    {
        $query = RemRepu::query();
        $query->select('remrepu2.*','remrepu1.*', 'sucursal_nombre',DB::raw("CONCAT((CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,(CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END)) AS tecnico_nombre"), 'producto_nombre', 'producto_serie');
        $query->join('remrepu2', 'remrepu1.id', '=', 'remrepu2.remrepu2_remrepu1');
        $query->join('producto', 'remrepu2.remrepu2_producto', '=', 'producto.id');
        $query->join('tercero', 'remrepu1_tecnico', '=', 'tercero.id');
        $query->join('sucursal', 'remrepu1_sucursal', '=', 'sucursal.id');
        $query->where('remrepu1_orden',$orden);

        $remrepu1 = $query->get();
        return $remrepu1;
    }
}
