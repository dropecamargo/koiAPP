<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache,DB;

class Visita extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visita';

    public $timestamps = false;

    /**
     * The document reference id.
     *
     * @var string
     */
    public $document = 'VI';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['visita_orden','visita_tecnico','visita_tiempo_transporte','visita_viaticos','visita_observaciones'];

    public function isValid($data)
    {
        $rules = [
            'visita_fecha_llegada' => 'required|date_format:Y-m-d',
            'visita_hora_llegada' => 'required|date_format:H:s',
            'visita_fecha_inicio' => 'required|date_format:Y-m-d',
            'visita_hora_inicio' => 'required|date_format:H:s',
            'visita_fecha_fin' => 'required|date_format:Y-m-d',
            'visita_hora_fin' => 'required|date_format:H:s',
            'visita_tiempo_transporte' => 'integer'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }


    public static function getVisita($id)
    {
        $query = Visita::query();
        $query->select('visita.*',   
            DB::raw("
                CONCAT(
                    (CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                        ELSE tercero_razonsocial
                    END)
                
                ) AS tercero_nombre"
            ));
        $query->join('orden', 'visita_orden', '=', 'orden.id');
        $query->join('tercero', 'visita_tecnico', '=', 'tercero.id');
        $query->where('visita_orden', $id);
        $query->orderBy('id', 'asc');
        $visita = $query->get();
        return $visita; 
    }

}
