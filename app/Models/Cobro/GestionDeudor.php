<?php

namespace App\Models\Cobro;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, DB;

class GestionDeudor extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'gestiondeudor';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['gestiondeudor_observaciones'];

    public function isValid($data)
    {
        $rules = [
            'gestiondeudor_proxima' => 'required',
            'gestiondeudor_hproxima' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getGestionDeudor($id){
        $query = GestionDeudor::query();
        $query->select('gestiondeudor.*', 'conceptocob_nombre', 'deudor_tercero', 'deudor_nit', 'deudor_digito', 'deudor_razonsocial', 'deudor_nombre1', 'deudor_nombre2', 'deudor_apellido1', 'deudor_apellido2', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                    (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                )
            ELSE tercero_razonsocial END)
        AS tercero_nombre"));
        $query->join('conceptocob','gestiondeudor_conceptocob', '=', 'conceptocob.id');
        $query->join('deudor','gestiondeudor_deudor', '=', 'deudor.id');
        $query->join('tercero','deudor_tercero', '=', 'tercero.id');
        $query->where('gestiondeudor.id', $id);
        return $query->first();
    }
}
