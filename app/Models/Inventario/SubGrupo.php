<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class SubGrupo extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
   protected $table = 'subgrupo';

   public $timestamps = false;

   /**
    * The key used by cache store.
    *
    * @var static string
    */
   public static $key_cache = '_subgrupo';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['subgrupo_nombre', 'subgrupo_codigo'];

   protected $boolean = ['subgrupo_activo'];

   public function isValid($data)
   {
       $rules = [
           'subgrupo_codigo' => 'required|max:4|unique:subgrupo',
           'subgrupo_nombre' => 'required|max:100',
       ];

       if ($this->exists){
           $rules['subgrupo_codigo'] .= ',subgrupo_codigo,' . $this->id;
       }else{
           $rules['subgrupo_codigo'] .= '|required';
       }

       $validator = Validator::make($data, $rules);
       if ($validator->passes()) {
           return true;
       }
       $this->errors = $validator->errors();
       return false;
   }

   public static function getSubGrupos()
   {
       if ( Cache::has( self::$key_cache) ) {
           return Cache::get( self::$key_cache );
       }

       return Cache::rememberForever( self::$key_cache , function() {
           $query = SubGrupo::query();
           $query->where('subgrupo_activo', true);
           $query->orderBy('subgrupo_nombre', 'asc');
           $collection = $query->lists('subgrupo_nombre', 'subgrupo.id');

           $collection->prepend('', '');
           return $collection;
       });
   }
}
