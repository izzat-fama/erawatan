<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndividuStatus extends Model
{
    protected $connection = 'mysqldbrawatan';

    protected $table = 'tblrefindividustatus';

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
    	'individu_id',
		'individustatusno',
		'statusindividu_id',
		'individustatustarikh',
		'individustatuscatatan',
		'employeeno',
		'idpenggunamasuk',
		'tkhmasamasuk',
		'idpenggunakmskini',
		'tkhmasakmskini'
	];

    public function refStatus()
    {
        return $this->belongsTo(Status::class, 'statusindividu_id');
    }
}
