<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peruntukan extends Model
{
    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrawatan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblrefperuntukan';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'peruntukantarikhmula',
        'peruntukantarikhakhir',
        'tarafjawatan_id',
        'statusperkahwinan_id',
        'peruntukan',
        'idpenggunamasuk',
        'idpenggunakmskini',
        'tkhmasakmskini'
    ];
}
