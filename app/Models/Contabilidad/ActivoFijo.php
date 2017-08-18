<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Tercero;
use Validator, DB;

class ActivoFijo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activofijo';

    public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['activofijo_placa','activofijo_serie', 'activofijo_compra', 'activofijo_activacion', 'activofijo_descripcion', 'activofijo_costo', 'activofijo_vida_util'];


    public function isValid($data)
    {
        $rules = [
            'activofijo_tipoactivo' => 'required|numeric',
            'activofijo_responsable' => 'required',
            'activofijo_compra' => 'required|date',
            'activofijo_costo' => 'required',
            'activofijo_vida_util' => 'numeric',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            if ($data['activofijo_costo'] <= 0) {
                $this->errors = 'El costo del activo debe ser mayor a 0.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getActivosFijos ()
    {
        $activofijo = ActivoFijo::query();
        $activofijo->select('activofijo.*', 'tipoactivo_nombre', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END) )  ELSE tercero_razonsocial END) AS tercero_nombre") );
        $activofijo->leftJoin('tipoactivo','activofijo_tipoactivo', '=', 'tipoactivo.id');
        $activofijo->leftJoin('tercero', 'activofijo_responsable', '=', 'tercero.id');
        return $activofijo->get();
    } 

    public static function getActivoFijo ($id)
    {
        $activofijo = ActivoFijo::query();
        $activofijo->select('activofijo.*', 'tipoactivo_nombre', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END) )  ELSE tercero_razonsocial END) AS tercero_nombre") );
        $activofijo->leftJoin('tipoactivo','activofijo_tipoactivo', '=', 'tipoactivo.id');
        $activofijo->leftJoin('tercero', 'activofijo_responsable', '=', 'tercero.id');
        $activofijo->where('activofijo_facturap1', $id) ;
        return $activofijo->get();
    } 

    public static function store($facturap1, Array $data)
    {
        $response = new \stdClass();
        $response->success = false;

        foreach ($data as $item) {
            // Recupero responsable
            $responsable = Tercero::where('tercero_nit', $item['activofijo_responsable'])->first();
            if (!$responsable instanceof Tercero) {
                $response->errors = 'No es posible recuperar responsable, por favor verifique la información o consulte al administrador';
                return $response;
            }
            // Recupero tipo activo 
            $tipoactivo = TipoActivo::find($item['activofijo_tipoactivo']);
            if (!$tipoactivo instanceof TipoActivo) {
                $response->errors = 'No es posible recuperar el tipo de activo, por favor verifique la información o consulte al administrador';
                return $response;
            }
            $activofijo = new ActivoFijo;
            $activofijo->fill($item);
            $activofijo->activofijo_responsable = $responsable->id;
            $activofijo->activofijo_tipoactivo = $tipoactivo->id;
            $activofijo->activofijo_facturap1 = $facturap1->id;
            $activofijo->save();
        }
        $response->success = true;
        return $response;
    }
}
