<?php

namespace App\Http\Controllers\Pengguna; //parent's name -- controller kepunyaai siapa

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;

use App\Individu;
use App\Entiti;
use App\Hubungan;
use App\MapStatus;
use App\JenisDokumen;
use App\Dokumen;
use App\Status;
use App\Tanggungan;

class IndividuController extends Controller
{

    public function dataSenaraiTanggungan()
    {
        $pengguna = Auth::user();

        /*$query = Individu::where('employeeno','=',$pengguna->profile->employeeno)
        ->where('individukeluarga','=','Y')
        ->with('refhubungan:hubungan')
        //->join('tblrefhubungan', 'tblrefindividu.hubungan_id', '=', 'tblrefhubungan.id')
        ->select([
            '*'
        ]);

        // Return respond
        return DataTables::of($query)
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
            return view('individu.actions', compact('individu'));
        })
        ->make(true);*/
        $query = Tanggungan::where('employeeno','=',$pengguna->profile->employeeno)
        ->select([
            '*'
        ]);
        return DataTables::of($query)
        ->addColumn('action', function ($individu) {
            return view('individu.actions', compact('individu'));
        })
        ->make(true);
        dd($query);
    }
     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('individu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $pengguna = Auth::user();

        $senarai_hubungan = Hubungan::whereNotIn('hubungankod', ['01'])
        ->select('id', 'hubungan')
        ->get();

        $map_status_pekerjaan = MapStatus::whereIn('kumpulanstatus_id', ['15'])
        ->select('id', 'status_id')
        ->get();

        $senarai_jenis_dokumen = JenisDokumen::whereIn('jenisdokumenkod', ['03','04','05'])
        ->select('id', 'jenisdokumen')
        ->get();

        return view('individu.borang', compact('pengguna', 'senarai_hubungan', 'map_status_pekerjaan', 
            'senarai_jenis_dokumen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if ($request->has('hantar'))
        {
            $request->validate([
                'individunama' => 'required',
                'hubungan_id' => 'required',
                'individunoid' => 'required|numeric',
                'individutarikhlahir' => 'required',
                'statuspekerjaan_id' => 'required',
            ]);

            if($request->input('hubungan_id') != 4)
            {
                 $request->validate([
                    'jenisdokumen_id' => 'required',
                    'filesokonganindividu' => 'required|mimes:docx,pdf,jpg,png',
                ]);
            }

            if ($request->has('individuoku'))
            {
                $request->validate([
                    'filesokonganoku' => 'required|mimes:docx,pdf,jpg,png',
                ]);
            }

             if ($request->has('individudaif'))
            {
                $request->validate([
                    'filesokongandaif' => 'required|mimes:docx,pdf,jpg,png',
                ]);
            }
        }/***END $request->has('hantar')****/
        else
        {
            $request->validate([
                'individunoid' => 'required|numeric',
            ]);
        }
          
            //dapatkan semua data dari borang
            $data = $request->all();
            if ($request->has('individuoku'))
            {
                $data['individuoku'] = "Y";
            }
            else
            {
                 $data['individuoku'] = "T";
            }

            if ($request->has('individudaif'))
            {
                $data['individudaif'] = "Y";
            }
            else
            {
                 $data['individudaif'] = "T";
            }

        $data['individukeluarga'] = "Y";
        $data['employeeno'] = Auth::user()->profile->employeeno;
        $data['idpenggunamasuk'] = Auth::user()->id;
        $data['tkhmasamasuk'] = Carbon::now();
        $data['tkhmasakmskini'] = Carbon::now();

       // Simpan data ke table tblrefindividu
        $individu = Individu::create($data);
        
        $dataStatus['individustatusno'] = 1;
        $dataStatus['statusindividu_id'] = $request->has('hantar') ? 24 : 23;
        $dataStatus['individustatustarikh'] = Carbon::now();
        $dataStatus['employeeno'] = $data['employeeno'];
        $dataStatus['idpenggunamasuk'] = Auth::user()->id;
        $dataStatus['tkhmasamasuk'] = Carbon::now();
        $dataStatus['tkhmasakmskini'] = Carbon::now();

        $individu->statusIndividu()->create($dataStatus);

         // Path untuk simpan dokumen
        $document_path = 'documents/' . auth()->user()->penggunanokp;

        if ($request->hasFile('filesokonganindividu'))
        {
            $docindividu = $request->file('filesokonganindividu');
            $namadocindividu = $docindividu->getClientOriginalName();

            // uploas dan simpan file
            $docindividuEncrypted = $docindividu->store($document_path, 'public');

            $dataDocindividu['jenisdokumen_id'] = $request->input('jenisdokumen_id');
            $dataDocindividu['erdokumennama'] = $namadocindividu;
            $dataDocindividu['erdokumenpath'] = $docindividuEncrypted;

            $individu->dokumen()->create($dataDocindividu);
        }

        // Sediakan data untuk dokumen OKU
        if ($request->hasFile('filesokonganoku'))
        {
            $docOKU = $request->file('filesokonganoku');
            $namadocOKU = $docOKU->getClientOriginalName();

             // uploas dan simpan file
            $docOKUEncrypted = $docOKU->store($document_path, 'public');

            $dataDocOKU['jenisdokumen_id'] = 6;
            $dataDocOKU['erdokumennama'] = $namadocOKU;
            $dataDocOKU['erdokumenpath'] = $docOKUEncrypted;

            $individu->dokumen()->create($dataDocOKU);
        }

         // Sediakan data untuk dokumen tambahan
        if ($request->hasFile('filesokongandaif'))
        {
            $docDaif = $request->file('filesokongandaif');
            $namadocDaif = $docDaif->getClientOriginalName();

             // uploas dan simpan file
            $docDaifEncrypted = $docDaif->store($document_path, 'public');

            $dataDocDaif['jenisdokumen_id'] = 7;
            $dataDocDaif['erdokumennama'] = $namadocDaif;
            $dataDocDaif['erdokumenpath'] = $docDaifEncrypted;

            $individu->dokumen()->create($dataDocDaif);
        }

        //Bagi respon akhir
        return redirect()->route('individu.index');
       
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
        
        $pengguna = Auth::user();

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
        
        $status = $individu->statusAkhirIndividu->statusindividu_id;

        return view('individu.edit', compact('individu', 'pengguna', 'senarai_hubungan', 'map_status_pekerjaan', 'senarai_jenis_dokumen', 'jenis_dokumen_id', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Individu $individu)
    {
        if ($request->has('hantar'))
        {
           
            $request->validate([
                'individunama' => 'required',
                'hubungan_id' => 'required',
                'individunoid' => 'required|numeric',
                'individutarikhlahir' => 'required',
                'statuspekerjaan_id' => 'required',
                'jenisdokumen_id' => 'required',
            ]);

            //jika hubungan bukan 4=DIRI SENDIRI, maka wajib ada dokumen sokongan
            if($request->input('hubungan_id') != 4)
            {
                //check samada dokumen sokongan telah wujud dalam db
                $fileInd = Dokumen::where('individu_id', $individu->id)
                    ->whereNotIn('jenisdokumen_id', [1, 2, 6, 7])
                    ->first();

                //jika dokumen sokongan belum wujud maka buat validation
                if(!$fileInd)
                {
                     $request->validate([
                        'jenisdokumen_id' => 'required',
                        'filesokonganindividu' => 'required|mimes:docx,pdf,jpg,png',
                    ]);
                }
            }
            
            if ($request->has('individuoku'))
            {
                //semak samada dokumen sokongan OKU telah wujud dalam DB
                $fileOKU = Dokumen::where('individu_id', $individu->id)
                ->whereIn('jenisdokumen_id', [6])
                ->first();

                //sekiranya dokumen sokongan OKU belum wujud maka buat validation
                if(!$fileOKU)
                {
                    $request->validate([
                        'filesokonganoku' => 'required|mimes:docx,pdf,jpg,png',
                    ]);
                }
                
            }

             if ($request->has('individudaif'))
            {
                //semak samada dokumen sokongan Daif telah wujud dalam DB
                $fileDaif = Dokumen::where('individu_id', $individu->id)
                ->whereIn('jenisdokumen_id', [7])
                ->first();

                //sekiranya dokumen sokongan Daif belum wujud maka buat validation
                if(!$fileDaif)
                {
                     $request->validate([
                        'filesokongandaif' => 'required|mimes:docx,pdf,jpg,png',
                    ]);
                }
            }
        }/***END $request->has('hantar')****/
        else
        {
            $request->validate([
                'individunoid' => 'required|numeric',
            ]);
        }

            //dapatkan semua data dari borang
            $data = $request->all();
            
            if ($request->has('individuoku'))
            {
                $data['individuoku'] = "Y";
            }
            else
            {
                 $data['individuoku'] = "T";
            }

            if ($request->has('individudaif'))
            {
                $data['individudaif'] = "Y";
            }
            else
            {
                 $data['individudaif'] = "T";
            }


            //$date['individutarikhlahir'] = date_format($request->input('individutarikhlahir'), 'Y-m-d');
            $data['idpenggunakmskini'] = Auth::user()->id;
            $data['tkhmasakmskini'] = Carbon::now();

           // Kemaskini data ke table tblrefindividu
            $individu->update($data);
            
        if ($individu->statusIndividu()->count()>0)
        {
            $statusNo = ++$individu
            ->statusIndividu()
            ->orderBy('id', 'desc')
            ->first()
            ->individustatusno;
        }
        else
        {
            $statusNo = 1;
        }

        //bole juga ringkaskan begini
        //$statusNo = ++$tuntutan->status()->orderBy('id', 'desc')->first()->ertuntutanstatusno ? 1;

        $dataStatus['individustatusno'] = $statusNo;
        $dataStatus['statusindividu_id'] = $request->has('hantar') ? 24 : 23;
        $dataStatus['individustatustarikh'] = Carbon::now();
        $dataStatus['employeeno'] = $individu->employeeno;
        $dataStatus['idpenggunamasuk'] = Auth::user()->id;
        $dataStatus['tkhmasamasuk'] = Carbon::now();
        $dataStatus['tkhmasakmskini'] = Carbon::now();

        $individu->statusIndividu()->create($dataStatus);
            // Path untuk simpan dokumen sokongan
            $document_path = 'documents/' . auth()->user()->penggunanokp;
            if ($request->hasFile('filesokonganindividu'))
            {
                //delete dokumen sediada
                Dokumen::where('individu_id', $individu->id)
                ->whereNotIn('jenisdokumen_id', [1, 2, 6, 7])
                ->delete();

                $docindividu = $request->file('filesokonganindividu');
                $namadocindividu = $docindividu->getClientOriginalName();

                // upload dan simpan file
                $docindividuEncrypted = $docindividu->store($document_path, 'public');

                $dataDocindividu['jenisdokumen_id'] = $request->input('jenisdokumen_id');
                $dataDocindividu['erdokumennama'] = $namadocindividu;
                $dataDocindividu['erdokumenpath'] = $docindividuEncrypted;

                $individu->dokumen()->create($dataDocindividu);

            }

            if ($request->hasFile('filesokonganoku'))
            {
                 //delete dokumen sediada
                Dokumen::where('individu_id', $individu->id)
                ->whereIn('jenisdokumen_id', [6])
                ->delete();

                $docOKU = $request->file('filesokonganoku');
                $namadocOKU = $docOKU->getClientOriginalName();

                 // uploas dan simpan file
                $docOKUEncrypted = $docOKU->store($document_path, 'public');

                $dataDocOKU['jenisdokumen_id'] = 6;
                $dataDocOKU['erdokumennama'] = $namadocOKU;
                $dataDocOKU['erdokumenpath'] = $docOKUEncrypted;

                $individu->dokumen()->create($dataDocOKU);
            }

            if ($request->hasFile('filesokongandaif'))
            {
                 //delete dokumen sediada
                Dokumen::where('individu_id', $individu->id)
                ->whereIn('jenisdokumen_id', [7])
                ->delete();

                $docDaif = $request->file('filesokongandaif');
                $namadocDaif = $docDaif->getClientOriginalName();

                 // uploas dan simpan file
                $docDaifEncrypted = $docDaif->store($document_path, 'public');

                $dataDocDaif['jenisdokumen_id'] = 7;
                $dataDocDaif['erdokumennama'] = $namadocDaif;
                $dataDocDaif['erdokumenpath'] = $docDaifEncrypted;

                $individu->dokumen()->create($dataDocDaif);
            }

        //Bagi respon akhir
        return redirect()->route('individu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Individu $individu)
    {
        $individu->delete();

        //Bagi respon akhir
        return redirect()->route('individu.index');
    }

    public function ajaxKiraUmur(Request $request)
    {
        $nokp = $request->input('nokp');

        $tmp_tahun = substr($nokp,0,2);
        $tmp_bulan = substr($nokp,2,2);
        $tmp_hari = substr($nokp,4,2);
        
        /******--------TARIKH LAHIR----------*****/
        if($tmp_tahun >= 00 && $tmp_tahun <= 30) {
            $tmp_tahun = 2000+$tmp_tahun;
        }
        if($tmp_tahun >= 31 && $tmp_tahun <= 99) {
            $tmp_tahun = 1900+$tmp_tahun;
        }
        $tarikh_lahir = $tmp_hari."/".$tmp_bulan."/".$tmp_tahun;
        /**********----------UMUR-------------******************/
        $tmp_tarikh_lahir = $tmp_tahun."-".$tmp_bulan."-".$tmp_hari;
        $umur = date_create($tmp_tarikh_lahir)->diff(date_create('today'))->y;
        $tkh_lahir = $tmp_tahun."-".$tmp_bulan."-".$tmp_hari;
        
        //return $umur;
        return response()->json(['umur'=>$umur, 'tkh_lahir'=>$tkh_lahir]);

    }

    public function ajaxSetStatusAktif(Request $request)
    {
        $statussemakan = $request->input('statussemakan');

        $statusaktif = '';

        if($statussemakan == 4)
        {
            $statusaktif = 26;
        }
        else
        {
            $statusaktif = 27;
        }

        return response()->json(['statusaktif'=> $statusaktif]);
    }
}
