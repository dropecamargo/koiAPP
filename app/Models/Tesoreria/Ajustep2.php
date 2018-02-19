<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Base\Tercero;
use Validator, DB;

class Ajustep2 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajustep2';

	public $timestamps = false;

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['ajustep2_id_doc'];

	public function isValid($data)
	{
		$rules = [
			'ajustep2_tercero' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getAjustep2 ($id)
	{
        $query = Ajustep2::query();
        $query->select('ajustep2.*', 'documentos_nombre','facturap3_cuota','facturap1_numero', 'ajustep2_valor as facturap3_valor', DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre")
        );
        $query->join('tercero', 'ajustep2_tercero', '=', 'tercero.id');
        $query->join('documentos', 'ajustep2_documentos_doc', '=', 'documentos.id');
        $query->leftJoin('facturap3','ajustep2_id_doc', '=', 'facturap3.id');
        $query->leftJoin('facturap1','facturap3_facturap1', '=', 'facturap1.id');
        $query->where('ajustep2_ajustep1', $id);
        $ajustep2 = $query->get();

        return $ajustep2;
	}

    /**
    * Function for reportes history client in cartera
    */
    public static function historyProveiderReport(Tercero $tercero, Array $historyProveider, $i )
    {
        $response = new \stdClass();
        $response->success = false;
        $response->ajusteProveedor = [];
        $response->position = 0;

        $query = Ajustep2::query();
        $query->select('ajustep2.*', 'docafecta.documentos_nombre as docafecta', 'documento.documentos_nombre as documento','ajustep1_numero','ajustep1_fh_elaboro', 'regional_nombre');
        $query->where('ajustep2_tercero', $tercero->id);
        $query->join('ajustep1', 'ajustep1.id', '=', 'ajustep2_ajustep1');
        $query->join('regional', 'ajustep1.ajustep1_regional', '=', 'regional.id');
        $query->join('documentos as documento', 'ajustep1.ajustep1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'ajustep2.ajustep2_documentos_doc', '=', 'docafecta.id');
        $ajusteProveedor = $query->get();

        foreach ($ajusteProveedor as $value) {
            $historyProveider[$i]['documento'] = $value->documento;
            $historyProveider[$i]['numero'] = $value->ajustep1_numero;
            $historyProveider[$i]['regional'] = $value->regional_nombre;
            $historyProveider[$i]['docafecta'] = $value->docafecta;
            $historyProveider[$i]['id_docafecta'] = $value->ajustep2_id_doc;
            $historyProveider[$i]['cuota'] = 1;
            $historyProveider[$i]['naturaleza'] = $value->ajustep2_naturaleza;
            $historyProveider[$i]['valor'] = $value->ajustep2_valor;
            $historyProveider[$i]['elaboro_fh'] = $value->ajustep1_fh_elaboro;
            $i++;
        }
        $response->ajusteProveedor = $historyProveider;
        $response->position = $i;
        return $response;
    }
}
