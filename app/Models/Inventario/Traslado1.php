<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;

class Traslado1 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'traslado1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [];

	/**
	* The default pedido if documentos.
	*
	* @var static string
	*/

	public static $default_document = 'TRAS';	
}
