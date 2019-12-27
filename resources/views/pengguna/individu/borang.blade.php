<div class="row">
    <div class="col-md-12">

        <div class="form-group row">
            <label for="individukeluarga" class="col-sm-3 col-form-label">Keluarga</label>
            <div class="col-sm-9">
                {!! Form::select('individukeluarga', ['Y' => 'Ya', 'T' => 'Tidak'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="individunama" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
                {!!  Form::text('individunama', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="individunoid" class="col-sm-3 col-form-label">No. KP</label>
            <div class="col-sm-9">
                {!!  Form::text('individunoid', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="hubungan_id" class="col-sm-3 col-form-label">Hubungan</label>
            <div class="col-sm-9">
                {!! Form::select('hubungan_id', $senarai_hubungan, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="individu_id" class="col-sm-3 col-form-label">Catatan</label>
            <div class="col-sm-9">
                {!! Form::textarea('individucatatan', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div><!--/.col-md-12-->
</div><!--/.row-->