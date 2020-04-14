<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peruntukan extends Model
{
   	protected $connection = 'mysqldbrawatan';

    protected $table = 'tblrefperuntukan';

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
    	'peruntukantarikhmula',
		'peruntukantarikhakhir',
		'tarafjawatan_id',
		'statusperkahwinan_id',
		'idpenggunamasuk',
		'tkhmasamasuk',
		'idpenggunakmskini',
		'tkhmasakmskini'
	];
}
