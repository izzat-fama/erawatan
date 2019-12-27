@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-12">

            <form method="POST" action="{{ route('pengguna.tuntutan.update', $tuntutan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            
            <div class="card">


                <div class="card-header">
                    <p class="card-title">Tuntutan {{ $pengguna->penggunanama }}</p>
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
                                    <input type="text" class="form-control" value="{{ $pengguna->penggunanama }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bahagian" class="col-sm-3 col-form-label">Bahagian</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $pengguna->profile->entityname }}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ertuntutantarikhrawat" class="col-sm-3 col-form-label">Tarikh Rawatan</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="ertuntutantarikhrawat" value="{{ $tuntutan->ertuntutantarikhrawat }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="individu_id" class="col-sm-3 col-form-label">Pesakit</label>
                                <div class="col-sm-9">
                                    <select name="individu_id" class="form-control">
                                        <option value="">-- Sila Pilih --</option>
                                        @foreach( $pesakit as $individu )
                                        <option value="{{ $individu->id }}"{{ $individu->id == $tuntutan->individu_id ? ' selected=selected' : null }}>{{ $individu->individunama }}
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entiti_id" class="col-sm-3 col-form-label">Klinik</label>
                                <div class="col-sm-9">
                                    <select name="entiti_id" class="form-control">
                                        <option value="">-- Sila Pilih --</option>
                                        @foreach( $klinik as $entiti )
                                        <option value="{{ $entiti->id }}"{{ $entiti->id == $tuntutan->entiti_id ? ' selected=selected' : null }}>{{ $entiti->entitinama }}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="baki" class="col-sm-3 col-form-label">Baki Yang Boleh Dituntut (RM)</label>
                                <div class="col-sm-9">
                                    <input type="number" min="1" step="1" class="form-control" name="baki" value="{{ $jumlah_baki ?? "0.00" }}" readonly>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="ertuntutannoresit" class="col-sm-3 col-form-label">No. Resit</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="ertuntutannoresit" value="{{ $tuntutan->ertuntutannoresit }}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="ertuntutanamaun" class="col-sm-3 col-form-label">Amaun</label>
                                <div class="col-sm-9">
                                    <input type="number" min="1" step="1" class="form-control" name="ertuntutanamaun" value="{{ $tuntutan->ertuntutanamaun ?? "0.00" }}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="fileresit" class="col-sm-3 col-form-label">Muat Naik Resit</label>
                                <div class="col-sm-9">
                                    <input type="file" name="fileresit">

                                    <br>
                                    
                                    @if ($tuntutan->dokumen()->where('jenisdokumen_id', 2)->count() > 0)
                                    <a href="{{ asset('storage/' . $tuntutan->dokumen()->where('jenisdokumen_id', 2)->first()->erdokumenpath) }}">Download Resit Terdahulu</a>    
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="filedokumen" class="col-sm-3 col-form-label">Muat Naik Dokumen</label>
                                <div class="col-sm-9">
                                    <input type="file" name="filedokumen">
                                    
                                    <br>
                                    
                                    @if ($tuntutan->dokumen()->where('jenisdokumen_id', 1)->count() > 0)
                                    <a href="{{ asset('storage/' . $tuntutan->dokumen()->where('jenisdokumen_id', 1)->first()->erdokumenpath) }}">Download Dokumen Terdahulu</a>    
                                    @endif
                                </div>
                            </div>

                        </div><!--/.col-md-8-->
                        <div class="col-md-4">
                            <p><img src="{{ asset('images/placeholderuser.png') }}" class="img-fluid"></p>
                            
                            <div class="form-group row">
                                <div class="col-md-8">Jumlah Telah Dituntut</div>
                                <div class="col-md-4">
                                    {{ $jumlah_telah_dituntut ?? "0.00" }}
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-8">Baki</div>
                                <div class="col-md-4">
                                    {{ $jumlah_baki ?? "0.00" }}
                                </div>
                            </div>

                        </div><!--/.col-md-4-->
                    </div><!--/.row-->

                </div>

                <div class="card-footer">

                    <a href="{{ route('pengguna.tuntutan.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    
                    <input type="submit" name="hantar" value="Hantar" class="btn btn-success">

                </div>

            </div><!--/.card-->

            </form>


        </div><!--/.col-12-->

    </div><!--/.row-->

</div><!--/.container-->
@endsection