<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CapaianPengguna extends Model
{
    // Maklumat connection database untuk table tblcapaianpengguna
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model ini perlu hubungi
    protected $table = 'tblcapaianpengguna';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // Relationship kepada table tblpengguna
    public function pengguna()
    {
        // Perhubungan berlaku diantara column pengguna_id di tblcapaianpengguna
        // dan column id di tblpengguna
        return $this->belongsTo(User::class);
    }


}
