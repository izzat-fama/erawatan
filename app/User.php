<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    //maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrujukan';

    //maklumat nama table yang user ini perlu hubungi
    protected $table = 'tblpengguna';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'penggunanokp', 'email', 'erkatalaluan',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'erkatalaluan'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        //Relationship kepada table payrollfamaofficer
        return $this->hasOne(Profile::class, 'icno', 'penggunanokp');
    }

    //Relationship kepada table tblcapaianpengguna dimana aplikasi erawatan=3
    public function capaian()
    {
        //Relationship kepada table payrollfamaofficer
        return $this->hasOne(CapaianPengguna::class, 'pengguna_id')
        ->where('aplikasi_id', '=', 3);
    }

    //Semak role pengguna adakah admin (ID = 1)?
    public function isAdmin()
    {
        if(auth()->user()->capaian->perananpengguna_id == 1)
        {
            return true;
        }

        return false;
    }

    //Semak role pengguna adakah kewangan (ID = 7)?
    public function isKewangan()
    {
        if(auth()->user()->capaian->perananpengguna_id == 7)
        {
            return true;
        }

        return false;
    }

    //Semak role pengguna adakah penyemak pengurusan (ID = 2)?
    public function isAdminSemak()
    {
        if(auth()->user()->capaian->perananpengguna_id == 2)
        {
            return true;
        }

        return false;
    }

    //Semak role pengguna adakah pelulus pengurusan (ID = 3)?
    public function isAdminSah()
    {
        if(auth()->user()->capaian->perananpengguna_id == 3)
        {
            return true;
        }

        return false;
    }

    public function getAuthPassword()
    {
        return $this->erkatalaluan;
    }
}
