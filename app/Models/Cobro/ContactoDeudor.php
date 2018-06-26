<?php

namespace App\Models\Cobro;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator;

class ContactoDeudor extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'contactodeudor';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contactodeudor_nombre', 'contactodeudor_direccion', 'contactodeudor_telefono', 'contactodeudor_movil', 'contactodeudor_email', 'contactodeudor_cargo'];

    public function isValid($data)
    {
        $rules = [
            'contactodeudor_nombre' => 'required|max:200',
            'contactodeudor_direccion' => 'max:200',
            'contactodeudor_email' => 'max:200',
            'contactodeudor_telefono' => 'required',
            'contactodeudor_cargo' => 'max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
