@extends('layouts.app')

@section('head')
 <meta name="csrf-token" content="{{ csrf_token() }}" />
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@endsection

@section('content')
<div class="container">

    <div class="row">

        <div class="col-12">
            <form method="POST" action="{{ route('individu.update', $individu->id) }}" enctype="multipart/form-data">
            @csrf <!--setiap form mesti ada : for security purpose-->
            @method('PATCH') <!--pass PATCH to HTML for update-->
            <div class="card">


                <div class="card-header">
                    <h3 class="card-title">Tanggungan {{ $pengguna->penggunanama }}</h3>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">

                            <div class="form-group row">
                                <label for="penggunanama" class="col-sm-3 col-form-label">Nama Kakitangan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $pengguna->penggunanama }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bahagian" class="col-sm-3 col-form-label">Bahagian</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $pengguna->profile->entityname }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="individunama" class="col-sm-3 col-form-label">Nama Tanggungan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="individunama" value="{{ $individu->individunama }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hubungan_id" class="col-sm-3 col-form-label">Hubungan</label>
                                <div class="col-sm-3">
                                    <select name="hubungan_id" class="form-control">
                                        <option value="">-- Sila Pilih --</option>
                                         @foreach( $senarai_hubungan as $hubungan )
                                        <option value="{{ $hubungan->id }}" {{($individu->hubungan_id == $hubungan->id ? 'selected' : '' )}}>{{ $hubungan->hubungan }}
                                        @endforeach
                                    </select>
                                </div>
                            
                                <label for="individunoid" class="col-sm-3 col-form-label">No K/P Tanggungan</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="individunoid" id="individunoid" value="{{ $individu->individunoid }}">
                                </div>
                            </div>                            

                            <div class="form-group row">
                                 <label for="individutarikhlahir" class="col-sm-3 col-form-label">Tarikh Lahir</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="individutarikhlahir" id="individutarikhlahir">
                                </div>

                                <label for="individuumur" class="col-sm-3 col-form-label">Umur</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="individuumur" id="individuumur">
                                </div>
                                </div>

                            <div class="form-group row">
                                <label for="statuspekerjaan_id" class="col-sm-3 col-form-label">Status Pekerjaan</label>
                                <div class="col-sm-9">
                                    <select name="statuspekerjaan_id" class="form-control">
                                        <option value="">-- Sila Pilih --</option>
                                         @foreach( $map_status_pekerjaan as $status_pekerjaan )
                                        <option value="{{ $status_pekerjaan->id }} " {{($individu->statuspekerjaan_id == $status_pekerjaan->id ? 'selected' : '' )}}>{{ $status_pekerjaan->status->status }}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenisdokumen_id" class="col-sm-3 col-form-label">Jenis Dokumen</label>
                                <div class="col-sm-4">
                                    <select name="jenisdokumen_id" class="form-control">
                                        <option value="" @if(isset($jenis_dokumen_id->jenisdokumen_id) && $jenis_dokumen_id->jenisdokumen_id == "") {{"selected"}} @endif>-- Sila Pilih --</option>
                                         @foreach( $senarai_jenis_dokumen as $jenis_dokumen )
                                        <option value="{{ $jenis_dokumen->id }}" @if(isset($jenis_dokumen_id->jenisdokumen_id) && $jenis_dokumen->id == $jenis_dokumen_id->jenisdokumen_id){{"selected"}} @endif >{{ $jenis_dokumen->jenisdokumen }}
                                        @endforeach
                                    </select>
                                </div>

                                <label for="filesokonganindividu" class="col-sm-2 col-form-label">Kad Pelajar/ Surat Tawaran / Sijil Nikah</label>
                                <div class="col-sm-3">
                                     @if ($individu->dokumen()->whereIn('jenisdokumen_id', [3, 4, 5])->count() > 0)
                                        <a href ="{{ asset('storage/' . $individu->dokumen()->whereIn('jenisdokumen_id', [3, 4, 5])->first()->erdokumenpath) }}" target="_blank"> Download Dokumen</a>
                                    @endif
                                    <input type="file" name="filesokonganindividu" id="">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="individuoku" class="col-sm-3 col-form-label">OKU</label>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="form-control" name="individuoku" @if ($individu->individuoku == 'Y') {{"checked"}}@endif>
                                    
                                </div>

                                <label for="filesokonganoku" class="col-sm-2 col-form-label">Dokumen OKU</label>
                                <div class="col-sm-3">
                                    @if ($individu->dokumen()->where('jenisdokumen_id', 6)->count() > 0)
                                        <a href ="{{ asset('storage/' . $individu->dokumen()->where('jenisdokumen_id', 6)->first()->erdokumenpath) }}" target="_blank"> Download Dokumen</a>
                                    @endif
                                    <input type="file" name="filesokonganoku" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="individudaif" class="col-sm-3 col-form-label">Daif?</label>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="form-control" id="individudaif" name="individudaif"  @if ($individu->individudaif == 'Y') {{"checked"}}@endif>
                                    
                                </div>

                                <label for="filesokongandaif" class="col-sm-2 col-form-label">Dokumen Daif</label>
                                <div class="col-sm-3">
                                    @if ($individu->dokumen()->where('jenisdokumen_id', 7)->count() > 0)
                                        <a href ="{{ asset('storage/' . $individu->dokumen()->where('jenisdokumen_id', 7)->first()->erdokumenpath) }}" target="_blank"> Download Dokumen</a>
                                    @endif
                                    <input type="file" name="filesokongandaif" value="">
                                </div>
                            </div>
                        </div><!--/.col-md-8-->
                    </div><!--/.row-->
                </div>

                <div class="card-footer">

                    <a href="{{ route('individu.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    @if($status == 23 || $status == 12 || $status == 4 )
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    
                    <input type="submit" name="hantar" value="Hantar" class="btn btn-success">

                    @endif
                </div>

            </div><!--/.card-->


        </form>

        </div><!--/.col-12-->

    </div><!--/.row-->

</div><!--/.container-->
@endsection
@section('script')

<script>
$(document).ready( function () {
    kiraUmur();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#individunoid").focusout(function(e){
        e.preventDefault();
        kiraUmur();
    });

});
function kiraUmur(){
    var nokp = $("input[name=individunoid]").val();

    $.ajax({
       type:'POST',
       dataType:"JSON",
       headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
       url:'/ajaxKiraUmur',
       data:{nokp : nokp},
       success:function(data){
            $("#individutarikhlahir").val(data.tkh_lahir);
            $("#individuumur").val(data.umur);
       }
    });
}

</script>
@endsection