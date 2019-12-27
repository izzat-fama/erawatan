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