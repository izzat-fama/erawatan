<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapStatus extends Model
{
    protected $connection = 'mysqldbrujukan';

    protected $table = 'tblmapstatus';

    // Relationship ke table tblmapstatus
    public function status()
    {
    	return $this->belongsTo(Status::class,'status_id');
    }

    // Relationship ke table tblrefkumpulanstatus
    public function kumpulanstatus()
    {
    	return $this->belongsTo(KumpulanStatus::class);
    }
}
