<a href="{{ route('pengguna.individu.edit', $individu->id) }}" class="btn btn-sm btn-info">KEMASKINI</a>


<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $individu->id }}">
    PADAM
</button>

<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $individu->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    
    <form method="POST" action="{{ route('pengguna.individu.destroy', $individu->id) }}">
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
        <strong>AWAS!</strong>. Adakah anda bersetuju untuk menghapuskan rekod ID: {{ $individu->id }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-danger">Teruskan</button>
    </div>
    </div>

    </form>

</div>
</div>