<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

class TipoAjuste2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipoajuste2';

    public $timestamps = false;

    /**
     * Get the attributes for the tipoproducto.
     */
    public function tipoproducto()
    {
        return $this->hasOne('App\Models\Inventario\TipoProducto', 'id' , 'tipoajuste2_tipoproducto');
    }
}
