<?php

namespace App\Http\Controllers\Kewangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Tuntutan;
use App\TuntutanStatus;
use App\Entiti;

class TuntutanStatusController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Sediakan dataStatus untuk table tblertuntutanstatus
        $data['ertuntutan_id'] = $id;
        $data['statustuntutan_id'] = 25;
        $data['ertuntutanstatuscatatan'] = $request->input('ertuntutanstatuscatatan');
        $data['tkhmasakmskini'] = Carbon::now();

        // Simpan dataStatus kepada table tblertuntutanstatus
        TuntutanStatus::create($data);

        return redirect()->back();
    }
}
