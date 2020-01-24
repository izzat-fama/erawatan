<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TuntutanStatus extends Model
{
    protected $connection = 'mysqldbrawatan';

    protected $table = 'tblertuntutanstatus';

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

    public function refStatus()
    {
        return $this->belongsTo(Status::class, 'statustuntutan_id');
    }
}
