@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-12">

            {!! Form::model($individu, ['route' => ['pengguna.individu.update', $individu->id], 'enctype' => 'multipart/form-data']) !!}
            @method('PATCH')
            <div class="card">


                <div class="card-header">
                    <p class="card-title">Kemaskini Rekod Individu</p>
                </div>

                <div class="card-body">

                    @include('layouts.alerts')

                    @include('pengguna.individu.borang')

                </div>

                <div class="card-footer">

                    <a href="{{ route('pengguna.individu.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">

                </div>

            </div><!--/.card-->

            {!! Form::close() !!}


        </div><!--/.col-12-->

    </div><!--/.row-->

</div><!--/.container-->
@endsection