<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entiti extends Model
{
    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblrefentiti';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
