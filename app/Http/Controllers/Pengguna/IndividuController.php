<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

use App\User;
use App\Individu;
use App\Hubungan;

class IndividuController extends Controller
{
    public function __construct()
    {
        // Tetapan lokasi folder resources/views/admin/tuntutan
        $this->theme = 'pengguna.individu';
    }

    public function datatables(Request $request)
    {
        $query = Individu::where('employeeno', auth()->user()->profile->employeeno)
            ->select([
                'tblrefindividu.*'
            ]);

        // Return response ajax datatables
        return DataTables::of($query)
        ->addColumn('hubungan', function ($individu) {
            return $individu->hubungan->hubungan ?? null;
        })
        ->addColumn('action', function ($individu) {
            return view($this->theme . '.actions', compact('individu'));
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
        return view($this->theme . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $senarai_hubungan = Hubungan::pluck('hubungan', 'id');
        return view($this->theme . '.create', compact('senarai_hubungan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'individunama' => 'required'
        ]);

        $data = $request->all();
        $data['employeeno'] = auth()->user()->profile->employeeno;

        Individu::create($data);

        return redirect()->route('pengguna.individu.index')->with('alert-success', 'Rekod berjaya ditambah');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Individu $individu)
    {
        return view($this->theme . '.show', compact('individu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Individu $individu)
    {
        $senarai_hubungan = Hubungan::pluck('hubungan', 'id');
        return view($this->theme . '.edit', compact('senarai_hubungan', 'individu'));
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
        $request->validate([
            'individunama' => 'required'
        ]);

        $data = $request->all();
        $data['employeeno'] = auth()->user()->profile->employeeno;

        $individu->update($data);

        return redirect()->route('pengguna.individu.index')->with('alert-success', 'Rekod berjaya dikemaskini');
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
        
        return redirect()->route('pengguna.individu.index')->with('alert-success', 'Rekod berjaya dipadam');
    }
}
