<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use App\Models\Inventario\Prodbode;
use Validator;

class RemRepu2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'remrepu2';

    public $timestamps = false;

    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['remrepu2_cantidad'];

    public function isValid($data)
    {
        $rules = [
            'remrepu2_cantidad' => 'required|numeric|min:1',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function updateProdbode(){

    }
}
