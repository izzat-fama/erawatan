<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Maklumat connection database untuk table tblpengguna
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model User ini perlu hubungi
    protected $table = 'tblpengguna';

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
        'name', 'penggunanokp', 'email', 'erkatalaluan',
    ];

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

    // Relationship kepada table payrollfamaofficer
    public function profile()
    {
        return $this->hasOne(Profile::class, 'icno', 'penggunanokp');
    }

    // Relationship kepada table tblcapaianpengguna dimana ID aplikasi erawatan = 3
    public function capaian()
    {
        return $this->hasOne(CapaianPengguna::class, 'pengguna_id')
        ->where('aplikasi_id', '=', 3);
    }

    // Semak role pengguna adakah admin (ID = 1)?
    public function isAdmin()
    {
        if (auth()->user()->capaian->perananpengguna_id == 1)
        {
            return true;
        }

        return false;
    }

    // Semak role pengguna adakah kewangan (ID = 7)?
    public function isKewangan()
    {
        if (auth()->user()->capaian->perananpengguna_id == 7)
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
