<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator, Cache;

class Linea extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'linea';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['linea_nombre','linea_margen_nivel1','linea_margen_nivel2','linea_margen_nivel3'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['linea_activo'];

    public function isValid($data)
    {
        $rules = [
            'linea_nombre' => 'required|max: 25',
            'linea_margen_nivel1' => 'required|numeric',
            'linea_margen_nivel2' => 'required|numeric',
            'linea_margen_nivel3' => 'required|numeric'

        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

}
