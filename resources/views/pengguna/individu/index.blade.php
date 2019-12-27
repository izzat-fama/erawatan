@extends('layouts.app')

@section('head')
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="{{ asset('plugin/select2/dist/css') }}/select2.min.css" rel="stylesheet" />
<script src="{{ asset('plugin/select2/dist/js') }}/select2.min.js"></script>
@endsection

@section('content')
<div class="container">

<div class="row">

<div class="col-12">

<div class="card">


<div class="card-header">
    Senarai Individu
</div>

<div class="card-body">

<!-- start tambah profil individu -->
<div class="row mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white" >PROFIL PENGGUNA</div>
                                    <div class="card-body"> 
                                        <div class="row">   
                                            <div class="col-md-4">
                                                
                                                <p align="center"><img src="{{ asset('images/placeholderuser.png') }}" class="img-thumbnail align-self-center" width="200"></p>
                                            </div>
                                            <div class="col-md-8">
                                                <table class="table table-borderless table-sm" align="center">
                                                    <tr>
                                                        <td width="190">Nama Kakitangan</td>
                                                        <td width="600">{{ $pengguna->profile->displayname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bahagian</td>
                                                        <td>{{ $pengguna->profile->entityname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Taraf Jawatan</td>
                                                        <td>{{ $pengguna->profile->position }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Taraf Perkahwinan</td>
                                                        <td>...</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Had Kelayakan</td>
                                                        <td>...</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Telah Dituntut</td>
                                                        <td>RM{{ $jumlah_telah_dituntut ?? "0.00"}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Baki Boleh Tuntut</td>
                                                        <td>...</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
<!-- end tambah profil individu -->




<p>
    <a href="{{ route('pengguna.individu.create') }}" class="btn btn-primary">Tambah Individu</a>
</p>


<table class="table table-hover table-bordered" id="individu-datatables">
<thead class="thead-light">
    <tr>
        <th>#</th>
        <th>KELUARGA</th>
        <th>NAMA</th>
        <th>HUBUNGAN</th>
        <th>CATATAN</th>
        <th>TINDAKAN</th>
    </tr>
</thead>
</table>

</div>

<div class="card-footer">
    <a href="{{ route('home') }}" class="btn btn-default">Kembali</a>
</div>

</div>


</div><!-- /col-12 -->

</div><!-- /row -->

</div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready( function () {
    $('#individu-datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pengguna.individu.datatables', ['entiti' => request()->input('entiti')]) }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'individukeluarga', name: 'individukeluarga' },
            { data: 'individunama', name: 'individunama' },
            { data: 'hubungan', name: 'hubungan' },
            { data: 'individucatatan', name: 'individucatatan' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>

@endsection