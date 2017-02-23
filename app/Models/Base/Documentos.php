<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Documentos extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documentos';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['documentos_codigo', 'documentos_nombre'];

    public function isValid($data)
    {
        $rules = [
            'documentos_codigo' => 'required|max:4|unique:documentos',
            'documentos_nombre' => 'required|max:25'
        ];

        if ($this->exists){
            $rules['documentos_codigo'] .= ',documentos_codigo,' . $this->id;
        }else{
            $rules['documentos_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
