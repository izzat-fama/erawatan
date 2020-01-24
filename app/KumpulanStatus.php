<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KumpulanStatus extends Model
{
    protected $connection = 'mysqldbrujukan';

    protected $table = 'tblrefkumpulanstatus';

    // Relationship ke table tblmapstatus
    public function map()
    {
    	return $this->hasMany(MapStatus::class, 'kumpulanstatus_id');
    }
}
