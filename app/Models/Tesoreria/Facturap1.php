<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Tercero;
use Validator, DB;

class Facturap1 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'facturap1';

    public $timestamps = false;

    /**
    * The default facturap if documentos.
    *
    * @var static string
    */

    public static $default_document = 'FPRO';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['facturap1_fecha','facturap1_vencimiento','facturap1_factura','facturap1_primerpago','facturap1_subtotal','facturap1_descuento','facturap1_impuestos', 'facturap1_retenciones','facturap1_apagar','facturap1_cuotas', 'facturap1_observaciones'];


    public function isValid($data)
    {
        $rules = [
            'facturap1_fecha' => 'required|date',
            'facturap1_vencimiento' => 'required|date',
            'facturap1_factura' => 'max:20',
            'facturap1_primerpago' => 'date',
            'facturap1_subtotal' => 'required|numeric',
            'facturap1_descuento' => 'required|numeric',
            'facturap1_cuotas' => 'required|numeric',
            'facturap1_retenciones' => 'numeric',
            'facturap1_tipogasto' => 'required',
            'facturap1_tipoproveedor' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carrito
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getFacturap ($id) {
        $facturap1 = Facturap1::query();
        $facturap1->select('entrada1.*','facturap1.*', DB::raw("(CASE WHEN fp.tercero_persona = 'N' THEN CONCAT(fp.tercero_nombre1,' ',fp.tercero_nombre2,' ',fp.tercero_apellido1,' ',fp.tercero_apellido2, (CASE WHEN (fp.tercero_razonsocial IS NOT NULL AND fp.tercero_razonsocial != '') THEN CONCAT(' - ', fp.tercero_razonsocial) ELSE '' END) )  ELSE fp.tercero_razonsocial END) AS tercero_nombre"), 'fp.tercero_nit','fp.tercero_persona','tipogasto_nombre', 'tipoproveedor_nombre', 'regional_nombre', 'sucursal_nombre',

            DB::raw("(CASE WHEN entr.tercero_persona = 'N' THEN CONCAT(entr.tercero_nombre1,' ',entr.tercero_nombre2,' ',entr.tercero_apellido1,' ',entr.tercero_apellido2, (CASE WHEN (entr.tercero_razonsocial IS NOT NULL AND entr.tercero_razonsocial != '') THEN CONCAT(' - ', entr.tercero_razonsocial) ELSE '' END) )  ELSE entr.tercero_razonsocial END) AS entrada1_elaboro"), 'entr.tercero_nit AS entrada1_nit'
            );

        $facturap1->join('tercero AS fp', 'facturap1_tercero', '=', 'fp.id');
        $facturap1->join('tipogasto', 'facturap1_tipogasto', '=', 'tipogasto.id');
        $facturap1->join('tipoproveedor', 'facturap1_tipoproveedor', '=', 'tipoproveedor.id');
        $facturap1->join('regional', 'facturap1_regional', '=', 'regional.id');
        $facturap1->leftJoin('entrada1', 'facturap1_entrada1', '=', 'entrada1.id');
        $facturap1->leftJoin('sucursal', 'entrada1.entrada1_sucursal', '=', 'sucursal.id');
        $facturap1->leftJoin('tercero AS entr', 'entrada1.entrada1_usuario_elaboro', '=', 'entr.id');
        $facturap1->where('facturap1.id', $id);
        return $facturap1->first();
    }

    public function calculateTotal(){
        $retenciones = $this->calculateRetenciones();
        $impuestos = $this->calculateImpuestos();
        $apagar = $impuestos->total_impuestos + $this->facturap1_subtotal;
        $apagar = $apagar - $this->facturap1_descuento;
        $apagar = $apagar - $retenciones->total_retefuentes;

        $this->facturap1_retenciones = $retenciones->total_retefuentes;
        $this->facturap1_impuestos = $impuestos->total_impuestos;
        $this->facturap1_apagar = $apagar;
        $this->save();
    }

    public function calculateRetenciones(){
        $facturap2 = Facturap2::query();
        $facturap2->select(DB::raw('SUM(facturap2_base) AS total_retefuentes'));
        $facturap2->where('facturap2_impuesto', null);
        $facturap2->where('facturap2_facturap1', $this->id);
        return $facturap2->first();
    }
    public function calculateImpuestos(){
        $facturap2 = Facturap2::query();
        $facturap2->select(DB::raw('SUM(facturap2_base) AS total_impuestos'));
        $facturap2->where('facturap2_retefuente', null);
        $facturap2->where('facturap2_facturap1', $this->id);
        return $facturap2->first();
    }

    /**
    * Function for reportes history proveedor
    */
    public static function historyProveiderReport(Tercero $tercero, Array $historyClient, $i )
    {
        $response = new \stdClass();
        $response->success = false;
        $response->facturaProveedor = [];
        $response->position = 0;

        $query = Facturap1::query();
        $query->select('facturap1.*', 'regional_nombre', 'documentos_nombre');
        $query->join('regional', 'facturap1_regional', '=', 'regional.id');
        $query->join('documentos', 'facturap1_documentos', '=', 'documentos.id');
        $query->where('facturap1_tercero', $tercero->id);
        $facturaProveedor = $query->get();

        foreach ($facturaProveedor as $value) {
            $historyClient[$i]['documento'] = $value->documentos_nombre;
            $historyClient[$i]['numero'] = $value->facturap1_numero;
            $historyClient[$i]['regional'] = $value->regional_nombre;
            $historyClient[$i]['docafecta'] = $value->documentos_nombre;
            $historyClient[$i]['id_docafecta'] = $value->facturap1_numero;
            $historyClient[$i]['cuota'] = $value->facturap1_cuotas;
            $historyClient[$i]['naturaleza'] = $value->facturap1_cuotas > 1 ? 'C' : 'D';
            $historyClient[$i]['valor'] = $value->facturap1_subtotal;
            $historyClient[$i]['elaboro_fh'] = $value->facturap1_fecha;
            $i++;
        }

        $response->facturaProveedor = $historyClient;
        $response->position = $i;
        return $response;
    }
}
