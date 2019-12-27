<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Mail;

use App\Tuntutan;
use App\Entiti;
use App\Mail\TuntutanBaru;

class TuntutanController extends Controller
{
    public function __construct()
    {
        // Tetapan lokasi folder resources/views/admin/tuntutan
        $this->theme = 'admin.tuntutan';
    }

    public function datatables(Request $request)
    {
        // Query ke table tuntutan
        // Check filter custom based on Entiti
        if ($request->has('entiti') && !is_null($request->input('entiti')))
        {
            $query = Tuntutan::with('individu')
            ->where('entiti_id', '=', $request->input('entiti'))
            ->select([
                'tblertuntutan.*'
            ]);
        }
        else
        {
            $query = Tuntutan::with('individu')
            ->select([
                'tblertuntutan.*'
            ]);
            
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

        return view($this->theme . '.index', compact('senarai_entiti'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Dapatkan rekod user yang sedang login
        $pengguna = Auth::user();

        $pesakit = $pengguna->profile
        ->individu()
        ->select('individunama', 'id')
        ->get();

        $klinik = Entiti::whereIn('entitikod', ['02','03', '04'])
        ->select('id', 'entitinama')
        ->get();

        // Paparkan borang tuntutan
        // return $pengguna->profile->entityname;
        return view($this->theme . '.borang', compact('pengguna', 'pesakit', 'klinik'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Semak jenis submission (simpan = draf / hantar = baru)
        if ($request->has('hantar'))
        {
            // Validate data dari borang
            $request->validate([
                'ertuntutantarikhrawat' => 'required',
                'ertuntutannoresit' => 'required',
                'ertuntutanamaun' => 'required|numeric',
                'fileresit' => 'mimes:docx,pdf,jpg,png',
                'filedokumen' => 'mimes:docx,pdf,jpg,png'
            ]);
        }
        else
        {
            $request->validate([
                'fileresit' => 'mimes:docx,pdf,jpg,png',
                'filedokumen' => 'mimes:docx,pdf,jpg,png'
            ]);
        }

        // Dapatkan semua data dari borang
        $data = $request->all();
        $data['employeeno'] = Auth::user()->profile->employeeno;
        $data['idpenggunamasuk'] = Auth::user()->id;
        $data['tkhmasamasuk'] = Carbon::now();
        $data['tkhmasakmskini'] = Carbon::now();

        // Simpan data kepada table tblertuntutan
        $tuntutan = Tuntutan::create($data);

        // Sediakan dataStatus untuk table tblertuntutanstatus
        $dataStatus['ertuntutanstatusno'] = 1;
        $dataStatus['statustuntutan_id'] = $request->has('hantar') ?  24 : 23;
        $dataStatus['ertuntutanstatustarikh'] = Carbon::now();
        $dataStatus['employeeno'] = $data['employeeno'];
        $dataStatus['idpenggunamasuk'] = Auth::user()->id;
        $dataStatus['tkhmasamasuk'] = Carbon::now();
        $dataStatus['tkhmasakmskini'] = Carbon::now();

        // Simpan dataStatus kepada table tblertuntutanstatus
        $tuntutan->status()->create($dataStatus);

        // Path untuk simpan dokumen
        $document_path = 'documents/' . auth()->user()->penggunanokp;

        // Sediakan data untuk dokumen jenis resit
        if ($request->hasFile('fileresit'))
        {
            $resit = $request->file('fileresit');
            $namaresit = $resit->getClientOriginalName();

            // upload dan simpan file
            $resitEncrypted = $resit->store($document_path, 'public');

            $dataResit['jenisdokumen_id'] = 2;
            $dataResit['erdokumennama'] = $namaresit;
            $dataResit['erdokumenpath'] = $resitEncrypted;

            // Simpan rekod ke table tbldokumen
            $tuntutan->dokumen()->create($dataResit);
        }

        // Sediakan data untuk dokumen tambahan
        if ($request->hasFile('filedokumen'))
        {
            $dokumen = $request->file('filedokumen');
            $namadokumen = $dokumen->getClientOriginalName();

            $documentEncrypted = $dokumen->store($document_path, 'public');

            $dataDokumen['jenisdokumen_id'] = 1;
            $dataDokumen['erdokumennama'] = $namadokumen;
            $dataDokumen['erdokumenpath'] = $documentEncrypted;
            
            // Simpan rekod ke table tbldokumen
            $tuntutan->dokumen()->create($dataDokumen);
        }

        if ($request->has('hantar'))
        {
            Mail::to('system@erawatan.test')->send(new TuntutanBaru($tuntutan));
        }

        // Bagi respon akhir
        return redirect()->route('tuntutan.index');
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
    public function edit(Tuntutan $tuntutan)
    {
        $pengguna = Auth::user();
        // $pengguna = auth()->user();

        $pesakit = $pengguna->profile
        ->individu()
        ->select('individunama', 'id')
        ->get();

        $klinik = Entiti::whereIn('entitikod', ['02','03', '04'])
        ->select('id', 'entitinama')
        ->get();

        // Dapatkan jumlah telah dituntut
        $jumlah_telah_dituntut = Tuntutan::jumlahTelahDituntut($tuntutan->employeeno);

        return view($this->theme . '.edit', compact('tuntutan', 'pengguna', 'pesakit', 'klinik', 'jumlah_telah_dituntut'));
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

        // Semak jenis submission (simpan = draf / hantar = baru)
        if ($request->has('hantar'))
        {
            // Validate data dari borang
            $request->validate([
                'ertuntutantarikhrawat' => 'required',
                'ertuntutannoresit' => 'required',
                'ertuntutanamaun' => 'required|numeric',
                'fileresit' => 'required|mimes:docx,pdf,jpg,png',
                'filedokumen' => 'required|mimes:docx,pdf,jpg,png'
            ]);
        }

        // Dapatkan semua data dari borang
        $data = $request->all();
        $data['idpenggunakemaskini'] = Auth::user()->id;
        $data['tkhmasakmskini'] = Carbon::now();

        // Kemaskini data kepada table tuntutan
        $tuntutan->update($data);

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
        $dataStatus['statustuntutan_id'] = $request->has('hantar') ?  24 : 23;
        $dataStatus['ertuntutanstatustarikh'] = Carbon::now();
        $dataStatus['employeeno'] = $tuntutan->employeeno;
        $dataStatus['idpenggunamasuk'] = Auth::user()->id;
        $dataStatus['tkhmasamasuk'] = Carbon::now();
        $dataStatus['tkhmasakmskini'] = Carbon::now();

        // Simpan dataStatus kepada table tblertuntutanstatus
        $tuntutan->status()->create($dataStatus);

        if ($request->has('hantar'))
        {
            Mail::to('system@erawatan.test')->send(new TuntutanBaru($tuntutan));
        }

        // Bagi respon akhir
        return redirect()->route('tuntutan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tuntutan $tuntutan)
    {
        $tuntutan->delete();

        // return redirect()->route('tuntutan.index');
        return redirect()->back();
    }
}
