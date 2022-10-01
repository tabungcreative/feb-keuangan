<form method="POST" action="{{ route('akun.update-saldo') }}">
<!-- Modal -->
<div class="modal fade" id="modalUpdateSaldo-{{ $item->id }}" tabindex="-1" aria-labelledby="#modalUpdateSaldo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Saldo {{ $item->nama }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="akun_id" value="{{ $item->id }}">
                <div class="mb-3">
                    <label class="form-label">Tipe Update</label>
                    <select class="form-control" name="update_type" aria-label="Default select example">
                        <option selected value=""> --- Tipe Update -- </option>
                        <option value="add">Tambah</option>
                        <option value="substract">Kurangi</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Saldo</label>
                    <input type="number" name="saldo_awal" class="form-control">
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