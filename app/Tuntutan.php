<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tuntutan extends Model
{
    
    protected $connection = 'mysqldbrawatan';

    protected $table = 'tblertuntutan';

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
    	'employeeno',
		'ertuntutantarikhrawat',
		'individu_id',
		'entiti_id',
		'ertuntutannoresit',
		'ertuntutanamaun',
		'idpenggunamasuk',
		'tkhmasamasuk',
		'idpenggunakmskini',
		'tkhmasakmskini'
	];

    public function status()
    {
        return $this->hasMany(TuntutanStatus::class, 'ertuntutan_id');
    }

    public function statusAkhir()
    {
        return $this->hasOne(TuntutanStatus::class, 'ertuntutan_id')
        ->orderBy('id', 'desc');
    }

    public function entiti()
    {
        return $this->belongsTo(Entiti::class, 'entiti_id', 'id')->withDefault(['entitinama'=>'TIADA REKOD']);
    }

    public function individu()
    {
        return $this->belongsTo(Individu::class, 'individu_id', 'id');
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'ertuntutan_id');
    }

    public static function jumlahTelahDituntut($employee)
    {
        $current_year = Carbon::now()->year;
        
        return self::where('employeeno', '=', $employee)
        ->whereYear('ertuntutantarikhrawat', $current_year)
        ->sum('ertuntutanamaun');
    }
}
