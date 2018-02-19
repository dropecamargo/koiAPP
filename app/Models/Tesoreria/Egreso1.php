<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, DB;

class Egreso1 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'egreso1';

    public $timestamps = false;

    public static $default_document = 'EGRE';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['egreso1_fecha','egreso1_fecha_cheque', 'egreso1_valor_cheque','egreso1_numero_cheque', 'egreso1_observaciones'];

    protected $boolean = ['egreso1_anulado'];

    public function isValid($data)
    {
        $rules = [
            'egreso1_numero_cheque' => 'required|max:15',
            'egreso1_fecha_cheque' => 'required|date',
            'egreso1_numero' => 'required|numeric',
            'egreso1_regional' => 'required|numeric',
            'egreso1_tercero' => 'required|numeric',
            'egreso1_cuentas' => 'required|numeric',
            'egreso1_fecha' => 'required|date'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carrito
            $egreso2 = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($egreso2) || $egreso2 == null || !is_array($egreso2) || count($egreso2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el egreso.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function getEgreso($id){
        $query = Egreso1::query();
        $query->select('egreso1.*','regional_nombre','cuentabanco_nombre',DB::raw("(CASE WHEN t.tercero_persona = 'N'
                    THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE t.tercero_razonsocial END)
                AS tercero_nombre"),
                DB::raw("CONCAT(elab.tercero_nombre1, ' ', elab.tercero_nombre2, ' ', elab.tercero_apellido1, ' ', elab.tercero_apellido2) as elaboro_nombre")
            );
        $query->join('tercero as t', 'egreso1_tercero', '=', 't.id');
        $query->join('tercero as elab', 'egreso1_usuario_elaboro', '=', 'elab.id');
        $query->join('regional', 'egreso1_regional', '=', 'regional.id');
        $query->join('cuentabanco', 'egreso1_cuentas', '=', 'cuentabanco.id');
        $query->where('egreso1.id', $id);
        return $query->first();
    }
}
