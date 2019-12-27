<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapStatus extends Model
{
    // Maklumat connection database untuk table tblrefstatus
    protected $connection = 'mysqldbrujukan';

    // Maklumat nama table yang model ini perlu hubungi
    protected $table = 'tblmapstatus';

    // Relationship ke table tblmapstatus
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Relationship ke table tblrefkumpulantatus
    public function kumpulanstatus()
    {
        return $this->belongsTo(KumpulanStatus::class);
    }
}
