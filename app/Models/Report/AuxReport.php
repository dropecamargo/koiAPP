<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use DB, Log;

class AuxReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
	*/
    protected $table = 'auxreporte';

    public $timestamps = false;

    public static function insertInTable($document, Array $arrayCostos, $type, $rollback)
    {
    	$valuesRegionales = array(
    		'1V' => 'auxreporte_double0',
    		'1D' => 'auxreporte_double1',
    		'1d' => 'auxreporte_double2',
    		'2V' => 'auxreporte_double3',
    		'2D' => 'auxreporte_double4',
    		'2d' => 'auxreporte_double5',
    		'3V' => 'auxreporte_double6',
    		'3D' => 'auxreporte_double7',
    		'3d' => 'auxreporte_double8',
    		'4V' => 'auxreporte_double9',
    		'4D' => 'auxreporte_double10',
    		'4d' => 'auxreporte_double11',
    		'5V' => 'auxreporte_double12',
    		'5D' => 'auxreporte_double13',
    		'5d' => 'auxreporte_double14',
    	);

    	DB::beginTransaction();
    	try {
    		if ($type == 'F') {

	    		foreach ($document as $key => $item)
	    		{
	    			$referenciaVenta = $item->regional.'V';
	    			$referenciaDescuento = $item->regional.'D';

			        $auxReport = new AuxReport;
			        $auxReport->auxreporte_varchar1 = $item->unidadnegocio_nombre;
			        $auxReport->auxreporte_varchar2 = $item->linea_nombre;
			        $auxReport->auxreporte_varchar3 = $item->categoria_nombre;
			        $auxReport->auxreporte_varchar4 = $item->subcategoria_nombre;
			        $auxReport->$valuesRegionales[$referenciaVenta] = $item->ventas;
			    	$auxReport->$valuesRegionales[$referenciaDescuento] = $item->descuentos;
			        $auxReport->auxreporte_integer1 = $item->unidadnegocio;
			        $auxReport->auxreporte_integer2 = $item->linea;
			        $auxReport->auxreporte_integer3 = $item->categoria;
			        $auxReport->auxreporte_integer4 = $item->subcategoria;
			        $auxReport->save();

                    if (!isset($arrayCostos["$item->regional_$item->unidadnegocio_$item->linea_$item->categoria_$item->subcategoria"])) {
                        $arrayCostos["$item->regional-$item->unidadnegocio-$item->linea-$item->categoria-$item->subcategoria"] = $item->costo;
                    }else{
                        $arrayCostos["$item->regional-$item->unidadnegocio-$item->linea_$item->categoria-$item->subcategoria"] += $item->costo;
                    }
	    		}
    		} elseif ($type == 'DEV') {

                foreach ($document as $key => $item)
                {
                    $referenciaDevolucion = $item->regional.'d';

                    $auxReport = new AuxReport;
                    $auxReport->auxreporte_varchar1 = $item->unidadnegocio_nombre;
                    $auxReport->auxreporte_varchar2 = $item->linea_nombre;
                    $auxReport->auxreporte_varchar3 = $item->categoria_nombre;
                    $auxReport->auxreporte_varchar4 = $item->subcategoria_nombre;
                    $auxReport->$valuesRegionales[$referenciaDevolucion] = $item->devoluciones;
                    $auxReport->auxreporte_integer1 = $item->unidadnegocio;
                    $auxReport->auxreporte_integer2 = $item->linea;
                    $auxReport->auxreporte_integer3 = $item->categoria;
                    $auxReport->auxreporte_integer4 = $item->subcategoria;
                    $auxReport->save();

                    // Register array costos
                    if (!isset($arrayCostos["$item->regional_$item->unidadnegocio_$item->linea_$item->categoria_$item->subcategoria"])) {
                        $arrayCostos["$item->regional-$item->unidadnegocio-$item->linea-$item->categoria-$item->subcategoria"] = $item->costo;
                    }else{
                        $arrayCostos["$item->regional-$item->unidadnegocio-$item->linea_$item->categoria-$item->subcategoria"] += $item->costo;
                    }
                }
    		}

    		if ($rollback)
    			DB::rollback();

            return $arrayCostos;
    	} catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
    		abort(500);
    	}
    }
}
