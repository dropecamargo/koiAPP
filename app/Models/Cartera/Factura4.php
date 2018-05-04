<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Factura4 extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'factura4';

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['factura4_comment'];

    public function isValid($data)
    {
        $rules = [
            'factura4_comment' => 'required|max:250'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function getComments($id){
        $comments = Factura4::query();
        $comments->where('factura4_factura2', $id);
        return $comments->get();
    }
}
