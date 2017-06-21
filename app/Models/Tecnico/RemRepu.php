<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use Validator;

class RemRepu extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'remrepu';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['remrepu_cantidad'];

    public static $default_document = 'REMR';

    public function isValid($data)
    {
        $rules = [

            'remrepu_cantidad' => 'required|numeric|min:1',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
