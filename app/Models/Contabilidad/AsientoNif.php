<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class AsientoNif extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'asienton1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['asienton1_mes', 'asienton1_ano', 'asienton1_dia', 'asienton1_folder', 'asienton1_documento', 'asienton1_numero', 'asienton1_detalle', 'asienton1_documentos', 'asienton1_id_documentos'];


    public static function getAsientoNif($id)
    {
        $query = AsientoNif::query();
        $query->select('asienton1.*', 'folder_nombre', 'documento_nombre', 't.tercero_nit', 'documento_tipo_consecutivo', DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2) ELSE t.tercero_razonsocial END) as tercero_nombre"), 'u.username as username_elaboro');
        $query->join('tercero as t', 'asienton1_beneficiario', '=', 't.id');
        $query->join('tercero as u', 'asienton1_usuario_elaboro', '=', 'u.id');
        $query->join('documento', 'asienton1_documento', '=', 'documento.id');
        $query->join('folder', 'asienton1_folder', '=', 'folder.id');
        $query->where('asienton1.id', $id);
        return $query->first();
    }

    public function setAsientoNif1DetalleAttribute($detail)
    {
        $this->attributes['asienton1_detalle'] = strtoupper($detail);
    }
}
