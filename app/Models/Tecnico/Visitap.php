<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache,DB;

class Visitap extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'visitap';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['visitap_orden','visitap_cantidad'];

    public function isValid($data)
    {
        $rules = [

            'visitap_cantidad' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;

    
    }
}
