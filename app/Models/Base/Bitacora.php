<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bitacora';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function isValid($data){}
        
     
}
