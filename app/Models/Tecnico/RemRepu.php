<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use Validator;
use App\Models\Tecnico\RemRepu2;

class RemRepu extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'remrepu1';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static $default_document = 'REMR';

    public function isValid($data)
    {
        $rules = [];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese productos para realizar la remisión de forma correcta.';
                return false;
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function readyDuplicate() {
        $ho = RemRepu::find($this->id);
        if(!$ho instanceof RemRepu){
            return "Motherfukerrr";
        }

        $remrepu = new RemRepu;
        $remrepu->remrepu1_orden = $this->remrepu1_orden;
        $remrepu->remrepu1_sucursal = $this->remrepu1_sucursal;
        $remrepu->remrepu1_tipo = 'L';
        $remrepu->remrepu1_tecnico = $this->remrepu1_tecnico;
        $remrepu->remrepu1_numero = $this->remrepu1_numero;
        $remrepu->remrepu1_documentos = $this->remrepu1_documentos;
        $remrepu->remrepu1_usuario_elaboro = $this->remrepu1_usuario_elaboro;
        $remrepu->remrepu1_fh_elaboro = $this->remrepu1_fh_elaboro;
        $remrepu->save();

        // Duplicate RemRepu2
        $remrepus2 = RemRepu2::where('remrepu2_remrepu1', $this->id)->get();
        foreach ($remrepus2 as $remrepu2) {
            $item = $remrepu2->replicate();
            $item->remrepu2_remrepu1 = $remrepu->id;
            $item->save();
        }

        return 'OK';
    }
}
