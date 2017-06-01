<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'pais';

    public $timestamps = false;
}
