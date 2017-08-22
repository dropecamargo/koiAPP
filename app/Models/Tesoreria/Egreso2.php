<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, DB;

class Egreso2 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'egreso2';

    public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['egreso2_tipopago','egreso2_documentos_doc'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['egreso2_documentos_doc','egreso2_id_doc'];

	public function isValid($data)
	{
		$rules = [
			'egreso2_tipopago' => 'required_if : facturap3_id, null',
			'egreso2_tercero' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {

            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getEgreso2($id)
	{
        $query = Egreso2::query();
        $query->select('egreso2.*','tipopago_nombre','facturap3_cuota','facturap1_numero', 'egreso2_valor as facturap3_valor', DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero2_nombre"));
        $query->join('tercero','egreso2_tercero', '=', 'tercero.id');
        $query->join('tipopago','egreso2_tipopago', '=', 'tipopago.id');
        $query->leftJoin('facturap3','egreso2_id_doc', '=', 'facturap3.id');
        $query->leftJoin('facturap1','facturap3_facturap1', '=', 'facturap1.id');
        $query->where('egreso2_egreso1', $id );
        $egreso2 = $query->get();

        return $egreso2;
	}
}
