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
    Senarai Tuntutan
</div>

<div class="card-body">

<p>
    <a href="{{ route('admin.tuntutan.create') }}" class="btn btn-primary">TUNTUTAN BARU</a>
    <a href="{{ route('admin.tuntutan.export', ['entiti' => request('entiti')]) }}" class="btn btn-success">EXPORT TUNTUTAN</a>
    <a href="{{ route('admin.tuntutan.pdf', ['entiti' => request('entiti')]) }}" class="btn btn-warning">DOWNLOAD PDF</a>

<div class="row mb-3">
    <div class="col-12">

        <form method="GET" action="{{ route('admin.tuntutan.index') }}">

        <div class="card">
            <div class="card-header">
                Filter Entiti
            </div>
            <div class="card-body">

                <div class="form-group">
                    <select name="entiti" class="form-control dropdown-select2">
                        @foreach ($senarai_entiti as $entiti)
                        <option value="{{ $entiti->id }}">{{ $entiti->entitinama }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cari Entiti</button>
            </div>
        </div>

        </form>

    </div>
</div>

<table class="table table-hover table-bordered" id="tuntutan-datatables">
<thead class="thead-light">
    <tr>
        <th>#</th>
        <th>TARIKH RAWATAN</th>
        <th>NAMA PESAKIT</th>
        <th>NAMA KLINIK</th>
        <th>AMAUN</th>
        <th>STATUS BAYARAN</th>
        <th>TINDAKAN</th>
    </tr>
</thead>
</table>

</div>

<div class="card-footer">

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
    $('#tuntutan-datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.tuntutan.datatables', ['entiti' => request()->input('entiti')]) }}",
        columns: [
            { data: 'id', name: 'tblertuntutan.id' },
            { data: 'ertuntutantarikhrawat', name: 'tblertuntutan.ertuntutantarikhrawat' },
            { data: 'individu.individunama', name: 'individu.individunama' },
            { data: 'entiti', name: 'entiti' },
            { data: 'ertuntutanamaun', name: 'tblertuntutan.ertuntutanamaun' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
<script>
    $(document).ready( function () {
        $('.dropdown-select2').select2();
    });
</script>

@endsection