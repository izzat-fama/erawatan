<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entiti extends Model
{
    protected $connection = 'mysqldbrujukan';

    protected $table = 'tblrefentiti';

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
    	'entiti_id',
		'entitikod',
		'entitinama',
		'negeri_id',
		'idpenggunamasuk',
		'tkhmasamasuk',
		'idpenggunakmskini',
		'tkhmasakmskini'
	];

    public function tuntutan()
    {
        return $this->hasMany(Tuntutan::class,'entiti_id');
    }
}
