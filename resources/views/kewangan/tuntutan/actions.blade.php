    <!-- Button trigger modal -->
    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-status-{{ $tuntutan->id }}">
        STATUS
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal-status-{{ $tuntutan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        
        <form method="POST" action="{{ route('kewangan.tuntutan.status.update', $tuntutan->id) }}">
        @csrf

        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sahkan Status Bayaran ID {{ $tuntutan->id }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Adakah anda pasti untuk mengesahkan status bayaran kepada TELAH DIBAYAR?</p>
            <div class="form-group">
                <label for="ertuntutanstatuscatatan">Catatan</label>
                <textarea name="ertuntutanstatuscatatan" class="form-control"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">YA</button>
        </div>
        </div>

        </form>

    </div>
    </div>