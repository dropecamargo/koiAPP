<?php

namespace App\Models\Cobro;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use DB;
class Deudor extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'deudor';

    public $timestamps = false;

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['deudor_razonsocial'];

    public static function getDeudor($id){
        $query = Deudor::query();
        $query->select('deudor.*', 'tercero_nit', DB::raw("CONCAT(deudor_nombre1,' ',deudor_nombre2,' ',deudor_apellido1,' ',deudor_apellido2) AS deudor_nombre"), DB::raw("(CASE WHEN tercero_persona = 'N'
            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                    (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                )
            ELSE tercero_razonsocial END)
        AS tercero_nombre"));
        $query->join('tercero', 'deudor_tercero', '=', 'tercero.id');
        $query->where('deudor.id', $id);

        return $query->first();
    }
}
