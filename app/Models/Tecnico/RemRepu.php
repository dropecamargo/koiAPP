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
}
