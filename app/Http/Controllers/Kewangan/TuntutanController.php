<?php

namespace App\Http\Controllers\Kewangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Mail;
use DB;
use App\Tuntutan;
use App\TuntutanStatus;
use App\Entiti;
use App\Mail\TuntutanBaru;

class TuntutanController extends Controller
{
    public function __construct()
    {
        // Tetapan lokasi folder resources/views/admin/tuntutan
        $this->theme = 'kewangan.tuntutan';
    }

    public function datatables(Request $request)
    {
        // Query ke table tuntutan
        // Check filter custom based on Entiti
        if ($request->has('entiti') && !is_null($request->input('entiti')))
        {
            $query = Tuntutan::join('tblertuntutanstatus', 'tblertuntutan.id', '=', 'tblertuntutanstatus.ertuntutan_id')
            ->with('individu')
            ->whereIn('tblertuntutanstatus.statustuntutan_id', [1,25])
            ->where('tblertuntutan.entiti_id', '=', $request->input('entiti'))
            ->select(['tblertuntutan.*', 'tblertuntutanstatus.statustuntutan_id']);
        }
        else
        {
            $query = Tuntutan::join('tblertuntutanstatus', function ($join) {
                $join->on('tblertuntutan.id', '=', 'tblertuntutanstatus.ertuntutan_id')
                     ->whereIn('tblertuntutanstatus.statustuntutan_id', [1, 25])
                     ->orderBy('tblertuntutanstatus.id', 'desc')
                     ->limit(1);
            })
            ->with('individu')
            ->select(['tblertuntutan.*', 'tblertuntutanstatus.id as status_id', 'tblertuntutanstatus.statustuntutan_id']);
        }

        // Return response ajax datatables
        return DataTables::of($query)
        ->addColumn('entiti', function ($tuntutan) {
            return $tuntutan->entiti->entitinama ?? "";
        })
        ->addColumn('status', function ($tuntutan) {
            return $tuntutan->statusAkhir->refStatus->status ?? "";
        })
        ->addColumn('action', function ($tuntutan) {
            return view($this->theme . '.actions', compact('tuntutan'));
        })
        ->addIndexColumn()
        ->make(true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $senarai_entiti = Entiti::whereIn('entitikod', ['02', '03', '04'])
        ->select('entitinama', 'id')
        ->get();

        $sub = TuntutanStatus::orderBy('id','DESC');

        $latestStatus = TuntutanStatus::select('ertuntutan_id', DB::raw('MAX(id) as last_id'))
            ->whereIn('statustuntutan_id', [1, 25])
            ->groupBy('ertuntutan_id');

        $query = Tuntutan::joinSub($latestStatus, 'latest_status', function ($join) {
                    $join->on('tblertuntutan.id', '=', 'latest_status.ertuntutan_id');
                })
                ->get();

        return view($this->theme . '.index', compact('senarai_entiti', 'query'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tuntutan $tuntutan)
    {
        // Sediakan data untuk table tblertuntutanstatus
        if ( $tuntutan->status()->count() > 0 )
        {
            $statusNo = ++$tuntutan->status()
            ->orderBy('id', 'desc')
            ->first()
            ->ertuntutanstatusno;
        }
        else
        {
            $statusNo = 1;
        }
        
        $dataStatus['ertuntutanstatusno'] = $statusNo;
        $dataStatus['statustuntutan_id'] = 25;
        $dataStatus['ertuntutanstatustarikh'] = Carbon::now();
        $dataStatus['employeeno'] = $tuntutan->employeeno;
        $dataStatus['idpenggunamasuk'] = auth()->user()->id;
        $dataStatus['tkhmasamasuk'] = Carbon::now();
        $dataStatus['tkhmasakmskini'] = Carbon::now();

        // Simpan dataStatus kepada table tblertuntutanstatus
        $tuntutan->status()->create($dataStatus);

        // Bagi respon akhir
        return redirect()->route('kewangan.tuntutan.index')->with('alert-danger', 'Rekod berjaya dikemaskini.');;
    }
}
