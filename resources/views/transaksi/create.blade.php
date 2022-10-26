@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center my-4">
    <div class="col-md-8" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('transaksi.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="form-control" value="{{ old('tanggal_transaksi') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="nama_transaksi" rows="3">
                            {{ old('nama_transaksi') }}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Akun Debit</label>
                        <select name="akun_debit_id" class="form-control select2" style="width: 100%">
                            <option value="" class="font-weight-bold">Pilih Akun Debit</option>
                            @foreach ($akun as $value)
                                <option value="{{ $value->id }}" {{$value->id == old('akun_debit_id') ? 'selected' : '' }}> {{$value->nama}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Akun Kredit</label>
                        <select name="akun_kredit_id" class="form-control select2" style="width: 100%;">
                            <option value="" class="font-weight-bold">Pilih Akun Kredit</option>
                            @foreach ($akun as $value)
                                <option value="{{ $value->id }}" {{$value->id == old('akun_kredit_id') ? 'selected' : '' }}> {{$value->nama}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Jumlah Transaksi</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" name="jumlah_transaksi" class="form-control" min="0" value="{{ old('jumlah_transaksi') ?? 0}}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
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
