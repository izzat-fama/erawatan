<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $connection = 'mysqldbrujukan';

    protected $table = 'dbrujukan.tblrefstatus';

    // Relationship ke table tblmapstatus
    public function map()
    {
    	return $this->hasMany(MapStatus::class, 'status_id');
    }
}
