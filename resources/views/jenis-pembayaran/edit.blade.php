@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-6" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Jenis Pembayaran</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('jenis-pembayaran.update', $data->id) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="nama_akun" value="{{ $data->nama }}">
                    <div class="mb-3">
                        <label class="form-label">Jenis Pembayaran</label>
                        <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Pembayaran</label>
                        <input type="text" name="kode" class="form-control" value="{{ $data->kode }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah_bayar" class="form-control" value="{{ $data->jumlah_bayar }}">
                    </div>
                
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection