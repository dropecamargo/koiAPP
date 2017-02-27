<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class PresupuestoAsesor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'presupuestoasesor';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['presupuestoasesor_asesor','presupuestoasesor_categoria','presupuestoasesor_ano','presupuestoasesor_mes','presupuestoasesor_valor'];

     public function isValid($data)
    {
        $rules = [
            'presupuestoasesor_asesor' => 'required|unique:presupuestoasesor',
            'presupuestoasesor_categoria' => 'required|unique:presupuestoasesor',
            'presupuestoasesor_ano' => 'required|unique:presupuestoasesor',
            'presupuestoasesor_mes' => 'required|unique:presupuestoasesor',
            'presupuestoasesor_valor' => 'required|numeric',
        ];

        if ($this->exists){
            $rules['presupuestoasesor_asesor'] .= ',presupuestoasesor_asesor,' . $this->id;
            $rules['presupuestoasesor_categoria'] .= ',presupuestoasesor_categoria,' . $this->id;
            $rules['presupuestoasesor_ano'] .= ',presupuestoasesor_ano,' . $this->id;
            $rules['presupuestoasesor_mes'] .= ',presupuestoasesor_mes,' . $this->id;
        }else{
            $rules['presupuestoasesor_asesor'] .= '|required';
            $rules['presupuestoasesor_categoria'] .= '|required';
            $rules['presupuestoasesor_ano'] .= '|required';
            $rules['presupuestoasesor_mes'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
