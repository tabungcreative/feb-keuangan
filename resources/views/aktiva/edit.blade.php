@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center my-4">
    <div class="col-md-8" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Aktiva</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('aktiva.update',$data->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label">Kode Aktiva</label>
                        <input type="text" name="kode_aktiva" class="form-control" value="{{ old('tahun_terbit',$data->kode_aktiva) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Aktiva</label>
                        <input type="text" name="nama_aktiva" class="form-control" value="{{ old('tahun_terbit',$data->nama_aktiva) }}">

                    <div class="mb-3">
                        <label class="form-label">Tanggal Perolehan</label>
                        <input type="date" name="tanggal_perolehan" max="<?= date('Y-m-d'); ?>" class="form-control" value="{{ old('tahun_terbit',$data->tanggal_perolehan) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Perolehan</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" name="harga_perolehan" class="form-control" min="0" value="{{ old('harga_perolehan',$data->harga_perolehan)}}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="peralatan" {{$data->kategori == 'peralatan' ? 'selected' : '' }}>Peralatan</option>
                            <option value="perlengkapan" {{$data->kategori == 'perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                            <option value="gedung" {{$data->kategori == 'gedung' ? 'selected' : '' }}>Gedung</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Umur Ekonomis</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="number" name="umur_ekonomis" class="form-control" min="0" value="{{ old('umur_ekonomis',$data->umur_ekonomis)  }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Tahun</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <!-- jQuery --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve' // need to override the changed default
            });
        });
    </script>
@endsection
