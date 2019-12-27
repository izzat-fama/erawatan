<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Maklumat connection database untuk table tblrefstatus
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model ini perlu hubungi
    protected $table = 'tblrefstatus';

    // Relationship ke table tblmapstatus
    public function map()
    {
        return $this->hasMany(MapStatus::class, 'status_id');
    }
}
