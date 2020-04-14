<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Individu extends Model
{
    protected $connection = 'mysqldbrawatan';

    protected $table = 'tblrefindividu';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
    *the attributes that are mass assignable
    *@var array
    **/
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
        'individudaif',
		'individucatatan',
		'individutarikhstatus',
		'individustatusoleh',
		'idpenggunamasuk',
		'tkhmasamasuk',
		'idpenggunakmskini',
		'tkhmasakmskini'
	];

	public function refHubungan()
    {
        return $this->belongsTo(Hubungan::class, 'hubungan_id');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'individu_id');
    }

    public function tuntutan()
    {
        return $this->hasMany(Tuntutan::class, 'individu_id');
    }

    public function statusIndividu()
    {
        return $this->hasMany(IndividuStatus::class, 'individu_id');
    }

    public function statusAkhirIndividu()
    {
        return $this->hasOne(IndividuStatus::class, 'individu_id')
        ->orderBy('id', 'desc');
    }

    public function refStatusAktif()
    {
        return $this->belongsTo(MapStatus::class, 'statusindividu_id');
    }

    public function kakitangan()
    {
        return $this->belongsTo(Profile::class, 'employeeno', 'employeeno');
    }
}
