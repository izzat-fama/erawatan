<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TuntutanStatus extends Model
{
    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrawatan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblertuntutanstatus';

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
        'ertuntutan_id',
        'ertuntutanstatusno',
        'statustuntutan_id',
        'ertuntutanstatustarikh',
        'ertuntutanstatuscatatan',
        'employeeno',
        'idpenggunamasuk',
        'tkhmasamasuk',
        'idpenggunakmskini',
        'tkhmasakmskini'
    ];
    // Relation kepada table tblrefstatus
    public function tuntutan()
    {
        return $this->belongsTo(Tuntutan::class, 'ertuntutan_id');
    }
    // Relation kepada table tblrefstatus
    public function refStatus()
    {
        return $this->belongsTo(Status::class, 'statustuntutan_id');
    }
}
