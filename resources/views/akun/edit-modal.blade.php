
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
                    <input type="text" name="kode" class="form-control" value="{{ old('kode', $item->kode) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama',$item->nama) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Akun Kas</label>
                    <select class="form-control" name="akun_kas" aria-label="Default select example">
                        <option selected value=""> --- Pilih Akun Kas -- </option>
                        <option value="kas_masuk" {{$item->akun_kas == 'kas_masuk' ? 'selected' : '' }}>Kas Masuk</option>
                        <option value="kas_keluar" {{$item->akun_kas == 'kas_keluar' ? 'selected' : '' }}>Kas Keluar</option>
                        <option value="kas_jalan" {{$item->akun_kas == 'kas_jalan' ? 'selected' : '' }}>Kas Jalan</option>
                        <option value="kas_bank" {{$item->akun_kas == 'kas_bank' ? 'selected' : '' }}>Kas Bank</option>
                        <option value="piutang" {{$item->akun_kas == 'piutang' ? 'selected' : '' }}>Piutang</option>
                        <option value="modal" {{$item->akun_kas == 'modal' ? 'selected' : '' }}>Modal</option>
                        <option value="hutang" {{$item->akun_kas == 'hutang' ? 'selected' : '' }}>Hutang</option>
                    </select>
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
