<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KumpulanStatus extends Model
{
    // Maklumat connection database untuk table tblrefstatus
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model ini perlu hubungi
    protected $table = 'tblrefkumpulanstatus';

    // Relationship ke table tblmapstatus
    public function map()
    {
        return $this->hasMany(MapStatus::class, 'kumpulanstatus_id');
    }
}
