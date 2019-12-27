<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Excel;
use PDF;
use App\Tuntutan;
use App\Exports\TuntutanExport;

class TuntutanExportController extends Controller
{
    public function export(Request $request)
    {
        $entiti = $request->has('entiti') ? $request->input('entiti') : null;

        return Excel::download(new TuntutanExport($entiti), 'senarai-tuntutan.xlsx');
    }

    public function pdf(Request $request)
    {
        $senarai_tuntutan = !is_null($request->input('entiti')) ? Tuntutan::where('entiti_id', '=', $request->input('entiti'))->get() : Tuntutan::all();

        $pdf = PDF::loadView('tuntutan/pdf', compact('senarai_tuntutan'));
        return $pdf->download('tuntutan.pdf');
    }
}
