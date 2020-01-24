<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;

use App\Individu;
use App\IndividuStatus;
use App\Hubungan;
use App\MapStatus;
use App\Profile;
use App\JenisDokumen;
use App\Dokumen;
use App\Status;
use App\Tanggungan;

class IndividuController extends Controller
{
    public function __construct()
    {
        // Tetapan lokasi folder resources/views/admin/individu
        $this->theme = 'admin.individu';
    }

    public function dataSenaraiTanggungan()
    {
        /*$query = Individu::Join('tblrefindividustatus','tblrefindividustatus.individu_id','=','tblrefindividu.id')
            ->where('tblrefindividustatus.statusindividu_id','=', 24)
            ->select(['tblrefindividustatus.statusindividu_id AS statusindividu_id','tblrefindividu.*']);*/

        /*if(auth()->user()->isAdminSemak())
        {
            $query = //DB::table('tblrefindividu AS individu')
            Individu::select('tblrefindividu.*')
            ->join(DB::raw('( SELECT ri.*
                            FROM (
                                SELECT ri.individu_id, MAX(ri.individustatusno) AS position
                                FROM tblrefindividustatus ri
                                GROUP BY ri.individu_id
                            ) ri_max
                            INNER JOIN tblrefindividustatus ri ON ri_max.individu_id = ri.individu_id 
                            AND ri_max.position = ri.individustatusno) ris'), 
            function($join)
            {
               $join->on('tblrefindividu.id', '=', 'ris.individu_id');
            })
            ->where('ris.statusindividu_id','=', 24)
            ->orderBy('tblrefindividu.id', 'ASC');
            //->get();
        }
        elseif(auth()->user()->isAdminSah())
        {
            $query = //DB::table('tblrefindividu AS individu')
            Individu::select('tblrefindividu.*')
            ->join(DB::raw('( SELECT ri.*
                            FROM (
                                SELECT ri.individu_id, MAX(ri.individustatusno) AS position
                                FROM tblrefindividustatus ri
                                GROUP BY ri.individu_id
                            ) ri_max
                            INNER JOIN tblrefindividustatus ri ON ri_max.individu_id = ri.individu_id 
                            AND ri_max.position = ri.individustatusno) ris'), 
            function($join)
            {
               $join->on('tblrefindividu.id', '=', 'ris.individu_id');
            })
            ->where('ris.statusindividu_id','=', 18)
            ->orderBy('tblrefindividu.id', 'ASC');
            //->get();
        }


        return DataTables::of($query)
        ->addColumn('namakakitangan', function ($individu) {
            return $individu->kakitangan->displayname ?? "";
        })
        ->addColumn('hubungan', function ($individu) {
            return $individu->refHubungan->hubungan ?? "";
        })
        ->addColumn('status', function ($individu) {
            return $individu->statusAkhirIndividu->refStatus->status ?? "";
        })
        ->addColumn('catatanstatus', function ($individu) {
            return $individu->statusAkhirIndividu->individustatuscatatan ?? "";
        })
        ->addColumn('statusaktif', function ($individu) {
            return $individu->refStatusAktif->status->status ?? "";
        })
        ->addColumn('action', function ($individu) {
            return view($this->theme .'.actions', compact('individu'));
        })
         ->make(true);*/

        if(auth()->user()->isAdminSemak())
        {
            $query =Tanggungan::where('statusid','=', 24)
            ->select(['*']);
        }
        elseif(auth()->user()->isAdminSah())
        {
            $query = Tanggungan::where('statusid','=', 18)
            ->select(['*']);
        }

        return DataTables::of($query)
        ->addColumn('action', function ($individu) {
            return view($this->theme .'.actions', compact('individu'));
        })
         ->make(true);
        //dd($query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->theme .'.index');    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Individu $individu)
    {
        $pengguna = Profile::where('employeeno', '=', $individu->employeeno)
        ->first();
        //dd($pengguna);
        $senarai_hubungan = Hubungan::whereNotIn('hubungankod', ['01'])
        ->select('id', 'hubungan')
        ->get();

        $map_status_pekerjaan = MapStatus::whereIn('kumpulanstatus_id', ['15'])
        ->select('id', 'status_id')
        ->get();

        //dropdown jenisdokumen drp tblrefdokumen
        $senarai_jenis_dokumen = JenisDokumen::whereIn('jenisdokumenkod', ['03','04','05'])
        ->select('id', 'jenisdokumen')
        ->get();

        //jenisdokumen_id dalam tblerdokumen(registered docs)
        $jenis_dokumen_id = Dokumen::whereNotIn('jenisdokumen_id', [1, 2, 6, 7])
        ->where('individu_id', '=' , $individu->id)
        ->select('jenisdokumen_id')
        ->first();

       
        if(auth()->user()->isAdminSemak())
        {
            $senarai_status_semakan = MapStatus::whereIn('kumpulanstatus_id', ['17'])
            ->select('id', 'status_id')
            ->get();
        }
        elseif(auth()->user()->isAdminSah())
        {
            $senarai_status_semakan = MapStatus::whereIn('kumpulanstatus_id', ['18'])
            ->select('id', 'status_id')
            ->get();

             $senarai_status_aktif = MapStatus::whereIn('kumpulanstatus_id', ['14'])
            ->select('id', 'status_id')
            ->get();
        }

        //dd($jenis_dokumen_id);
        return view($this->theme .'.semak', compact('individu', 'pengguna', 'senarai_hubungan', 'map_status_pekerjaan', 'senarai_jenis_dokumen', 'jenis_dokumen_id', 'senarai_status_semakan', 'senarai_status_aktif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
