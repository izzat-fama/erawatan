<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hubungan extends Model
{
     protected $connection = 'mysqldbrujukan';

    protected $table = 'dbrujukan.tblrefhubungan';

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
    	'hubungankod',
		'hubungan'
	];
}
