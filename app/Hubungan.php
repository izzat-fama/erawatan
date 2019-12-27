<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hubungan extends Model
{
    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblrefhubungan';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
