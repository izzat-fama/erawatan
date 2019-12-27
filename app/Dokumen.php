<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrawatan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblerdokumen';

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
        'ermenu_id',
        'jenisdokumen_id',
        'erdokumennama',
        'erdokumennoruj',
        'erdokumenpath',
        'erdokumentarikh',
        'employeeno',
        'individu_id',
        'ertuntutan_id',
        'idpenggunamasuk',
        'idpenggunakmskini',
        'tkhmasakmskini'
    ];

    // Relation ke table tuntutan
    public function tuntutan()
    {
        return $this->belongsTo(Tuntutan::class, 'ertuntutan_id');
    }
}
