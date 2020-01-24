<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use App\IndividuStatus;
use App\Individu;

class IndividuStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IndividuStatus $individustatus)
    {
        // Sediakan dataStatus untuk table tblrefindividustatus
        if ($individustatus->count()>0)
        {
            $statusNo = ++$individustatus
            ->where('individu_id', '=', $request->id)
            ->orderBy('id', 'desc')
            ->first()
            ->individustatusno;
        }
        else
        {
            $statusNo = 1;
        }
        //dd($id);
        $data['individu_id'] = $request->id;
        $data['individustatusno'] = $statusNo;
        $data['statusindividu_id'] = $request->input('statussemakan');
        $data['individustatustarikh'] = Carbon::now();
        $data['individustatuscatatan'] = $request->input('individustatuscatatan');
        $data['idpenggunamasuk'] = Auth::user()->id;
        $data['tkhmasamasuk'] = Carbon::now();
        $data['idpenggunakmskini'] = Auth::user()->id;
        $data['tkhmasakmskini'] = Carbon::now();
        // Simpan dataStatus kepada table tblertuntutanstatus
        //dd($data);
        IndividuStatus::create($data);

        if(auth()->user()->isAdminSah() && $request->input('statusaktif') != "")
        {
            $dataIndividu['statusindividu_id'] = $request->input('statusaktif');
            $dataIndividu['idpenggunakmskini'] = Auth::user()->id;
            $dataIndividu['tkhmasakmskini'] = Carbon::now();

        // Kemaskini status aktif ke table tblrefindividu
        Individu::whereId($request->id)->update($dataIndividu);
        }
       

        //Bagi respon akhir
        return redirect()->route('admin.individu.index');
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
