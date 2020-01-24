@extends('layouts.app')

@section('head')
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">

<div class="row">

<div class="col-12">

<div class="card">

<div class="card-header">
    Senarai Tanggungan
</div>

<div class="card-body">
    <p>
        <a href="{{ route('individu.create') }}" class="btn btn-primary">TANGGUNGAN BARU</a>
    </p>
<table class="table table-hover table-bordered" id="tanggungan-datatables">
<thead class="thead-light">
    <tr>
        <th>
        #
        </th>
        <th>
            NAMA TANGGUNGAN
        </th>
        <th>
            HUBUNGAN
        </th>
        <th>
            STATUS PENGESAHAN PENGURUSAN
        </th>
        <th>
            CATATAN PENGURUSAN
        </th>
        <th>
            STATUS AKTIF
        </th>
        <th>
            TINDAKAN
        </th>
    </tr>
</tead>
</table>

</div>

</div>


</div>

</div>

</div>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready( function () {
    kiraUmur();
    $('#tanggungan-datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('individu.dataSenaraiTanggungan') }}",
        columns: [
            { data: 'id', name: 'id',"width": "2%" },
            { data: 'individunama', name: 'individunama',"width": "15%" },
            { data: 'hubungan', name: 'hubungan', title: 'HUBUNGAN',  searchable: true, "width": "10%" },
            { data: 'status', name: 'status',"width": "10%" },
            { data: 'individustatuscatatan', name: 'individustatuscatatan',"width": "15%" },
            { data: 'statusaktif', name: 'statusaktif',"width": "10%" },
            { data: 'action', name: 'action', orderable: false, searchable: false,"width": "15%" },
           
        ]
    });

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
          $("#individuumur").val(data.umur);
       }
    });
}

</script>

@endsection