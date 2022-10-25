
<form method="POST" action="{{ route('akun.update', $item->id) }}">
<!-- Modal -->
<div class="modal fade" id="modalUpdate-{{ $item->id }}" tabindex="-1" aria-labelledby="#modalUpdateSaldo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{ $item->nama }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Kode Akun</label>
                    <input type="text" name="kode" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $item->nama }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
</form>
