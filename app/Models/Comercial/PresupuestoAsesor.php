<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;
use Validator;

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
    protected $fillable = ['presupuestoasesor_asesor','presupuestoasesor_ano'];

    public function isValid($data)
    {
        $rules = [
            'presupuestoasesor_asesor' => 'required',
            'presupuestoasesor_linea' => 'required',
            'presupuestoasesor_ano' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
