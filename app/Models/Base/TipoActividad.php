<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator;

class TipoActividad extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipoactividad';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipoactividad_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['tipoactividad_activo','tipoactividad_comercial','tipoactividad_tecnico','tipoactividad_cartera'];

    public function isValid($data)
    {
        $rules = [
            'tipoactividad_nombre' => 'required|max:25|unique:tipoactividad'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
