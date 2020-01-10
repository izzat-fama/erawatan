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
@include('layouts.alerts')
<p>
    <a href="{{ route('kewangan.tuntutan.export', ['entiti' => request('entiti')]) }}" class="btn btn-success">EXPORT TUNTUTAN</a>
    <a href="{{ route('kewangan.tuntutan.pdf', ['entiti' => request('entiti')]) }}" class="btn btn-warning">DOWNLOAD PDF</a>

<div class="row mb-3">
    <div class="col-12">

        <form method="GET" action="{{ route('kewangan.tuntutan.index') }}">

        <div class="card">
            <div class="card-header">
                Carian Kakitangan
            </div>
            <div class="card-body">

                <div class="form-group">
                    <select name="kakitangan" class="form-control dropdown-select2">
                        <option value="">Nama Kakitangan</option>
                        @foreach ($senarai_kakitangan as $kakitangan)
                            <option value ="{{ $kakitangan->employeeno}}">{{ $kakitangan->displayname}} </option>
                        @endforeach
                    </select>
                </div>    

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>

        </form>

    </div>
</div>

<table class="table table-hover table-bordered" id="tuntutan-datatables">
<thead class="thead-light">
    <tr>
        <th>ID TUNTUTAN</th>        
        <th>NAMA KAKITANGAN</th>
        <th>BAHAGIAN</th>
        <th>JAWATAN</th>
        <th>NO RESIT</th>
        <th>AMAUN</th>
        <th>STATUS BAYARAN</th>
        <th>TINDAKAN</th>
    </tr>
</thead>
<tbody>
    @foreach ($query as $status)
    <tr>
        <td>{{ $status->ertuntutan_id }}</td>
        <td>{{ $status->payrollfamaofficer->displayname ?? "" }}</td>
        <td>{{ $status->payrollfamaofficer->entityname ?? "" }}</td>
        <td>{{ $status->payrollfamaofficer->position ?? "" }}</td> 
        <td>{{ $status->ertuntutannoresit ?? "" }}</td>     
        <td>{{ $status->ertuntutanamaun ?? "" }}</td>
        <td>{{ $status->statusAkhir->refStatus->status ?? "" }}</td>
        <td></td>
    </tr>
    @endforeach
</tbody>
</table>

 {{-- {{ dd($status) }} --}}
</div>

<div class="card-footer">

</div>

</div>


</div><!-- /col-12 -->

</div><!-- /row -->

</div>
@endsection

