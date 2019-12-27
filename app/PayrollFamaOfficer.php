<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollFamaOfficer extends Model
{
    //
     //connection db'
     protected $connection = 'mysqldbrujukan';

     //table
     protected $table = 'payrollfamaofficer';
 
     //disable created_at & update_at
     public $timestamps = false;
}
