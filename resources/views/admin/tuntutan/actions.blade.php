    <a href="{{ route('admin.tuntutan.edit', $tuntutan->id) }}" class="btn btn-sm btn-info">EDIT</a>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-status-{{ $tuntutan->id }}">
        STATUS
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal-status-{{ $tuntutan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        
        <form method="POST" action="{{ route('admin.tuntutan.status.update', $tuntutan->id) }}">
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

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $tuntutan->id }}">
        DELETE
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal-delete-{{ $tuntutan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
        <form method="POST" action="{{ route('admin.tuntutan.destroy', $tuntutan->id) }}">
        @csrf
        @method('DELETE')

        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pengesahan Hapus Rekod</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <strong>AWAS!</strong>. Adakah anda bersetuju untuk menghapuskan rekod ID: {{ $tuntutan->id }}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Teruskan</button>
        </div>
        </div>

        </form>

    </div>
    </div>