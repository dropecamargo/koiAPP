<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class SaldoContableNif extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'saldoscontablesn';

    public $timestamps = false;
}
