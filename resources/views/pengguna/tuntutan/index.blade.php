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
    Senarai Tuntutan Kakitangan

</div>

<div class="card-body">

<!-- start profil individu -->
<div class="row mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white" >KAKITANGAN</div>
                                    <div class="card-body"> 
                                        <div class="row">   
                                            <div class="col-md-4">
                                                <p align="center"><img src="{{ asset('images/placeholderuser.png') }}" class="img-thumbnail align-self-center" width="200"></p>
                                            </div>
                                            <div class="col-md-8">
                                                <table class="table table-borderless table-sm" align="center">
                                                    <tr>
                                                        <td width="190">Nama Kakitangan</td>
                                                        <td width="600">: {{ Auth::user()->penggunanama }}</td>
                                                    </tr>
                                                     <tr>
                                                        <td width="190">No K/P</td>
                                                        <td width="600">: {{ Auth::user()->penggunanokp }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="190">Had Kelayakan</td>
                                                        <td width="600">: RM XXX.XX</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
<!-- end profil individu -->

<p>
      <a href="{{ route('pengguna.tuntutan.create') }}" class="btn btn-primary btn-align-end">TUNTUTAN BARU</a>
</p>

<div class="row mb-3">
    <div class="col-12">

        <form method="GET" action="{{ route('pengguna.tuntutan.index') }}">

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
                <button type="submit" class="btn btn-primary">Cari Klinik</button>
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
        ajax: "{{ route('pengguna.tuntutan.datatables', ['entiti' => request()->input('entiti')]) }}",
        columns: [
            { data: 'id', name: 'tblertuntutan.id' },
            { data: 'ertuntutantarikhrawat', name: 'tblertuntutan.ertuntutantarikhrawat' },
            { data: 'individu.individunama', name: 'individu.individunama' },
            { data: 'entiti', name: 'entiti' },
            { data: 'ertuntutanamaun', name: 'tblertuntutan.ertuntutanamaun' },
            { data: 'status', name: 'status' },
            //{ data: 'action', name: 'action', orderable: false, searchable: false }
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