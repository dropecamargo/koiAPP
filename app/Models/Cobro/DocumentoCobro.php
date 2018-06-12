<?php

namespace App\Models\Cobro;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class DocumentoCobro extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'documentocobro';

    public $timestamps = false;
}
