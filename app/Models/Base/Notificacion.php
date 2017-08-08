<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notificaciones';

    public $timestamps = false;
}
