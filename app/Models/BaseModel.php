<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Bitacora;
use Auth;

class BaseModel extends Model
{

	protected $nullable = [];

	protected $boolean = [];

	protected $bitacora = [];

	/**
	* Listen for save event
	*/
	public static function boot()
	{
		parent::boot();
	    static::saving(function($model) {
			self::setNullables($model);
	    });
	}

	/**
	* Set empty nullable fields to null
	* @param object $model
	*/
	protected static function setNullables($model)
	{
		foreach($model->nullable as $field) {
			if(empty($model->{$field}))
			{
				$model->{$field} = null;
			}
		}
	}

	/**
	* Set boolean fields
	* @param object $model
	*/
	public function fillBoolean(array $attributes)
	{
		foreach ($this->boolean as $value) {
        	$this->setAttribute($value, (isset($attributes[$value]) && $value == trim($attributes[$value])) ? true : false);
        }
	}

	/**
	* Set bitacora fields
	* @param object $model
	*/
	public function bitacora($model, array $attributes,$documento_id)
	{
		foreach ($this->bitacora as $item) {
			if ($attributes[$item] != $model->{$item}) {
    			$bitacoraModel = new Bitacora;
    			$bitacoraModel->bitacora_documento = $model->id;
				$bitacoraModel->bitacora_documentos =$documento_id;
				$bitacoraModel->bitacora_campo = $item;
				$bitacoraModel->bitacora_anterior =$model->{$item} ;
				$bitacoraModel->bitacora_nuevo = $attributes[$item];
				$bitacoraModel->bitacora_fh_elaboro = date('Y-m-d H:m:s');;
				$bitacoraModel->bitacora_usuario_elaboro = Auth::user()->id;
				$bitacoraModel->save();
			}
        }
	}
}
