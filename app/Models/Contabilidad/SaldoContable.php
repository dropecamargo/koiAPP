<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class SaldoContable extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'saldoscontables';

    public $timestamps = false;
}
