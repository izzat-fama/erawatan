<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $connection = 'mysqldbrawatan';

    protected $table = 'tblerdokumen';

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
    	'jenisdokumen_id',
		'erdokumennama',
		'erdokumennoruj',
		'erdokumenpath',
		'erdokumentarikh',
		'employeeno',
		'individu_id',
		'ertuntutan_id',
		'idpenggunamasuk',
		'tkhmasamasuk',
		'idpenggunakmskini',
		'tkhmasakmskini'
	];

    public function tuntutan()
    {
        return $this->belongsTo(Tuntutan::class, 'ertuntutan_id');
    }

    public function individu()
    {
        return $this->belongsTo(Individu::class, 'ertuntutan_id');
    }
}
