<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Individu extends Model
{
    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrawatan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblrefindividu';

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
        'individukeluarga',
        'employeeno',
        'individunoid',
        'jenispengenalan_id',
        'individunama',
        'hubungan_id',
        'individutarikhlahir',
        'statusindividu_id',
        'statuspekerjaan_id',
        'individuoku',
        'individucatatan',
        'individutarikhstatus',
        'individustatusoleh',
        'idpenggunamasuk',
        'idpenggunakmskini',
        'tkhmasakmskini'
    ];

    // Relationship kepada table ertuntutan
    public function tuntutan()
    {
        return $this->hasMany(Tuntutan::class, 'individu_id');
    }

    // Relationship kepada table ertuntutan
    public function hubungan()
    {
        return $this->belongsTo(Hubungan::class);
    }
}
