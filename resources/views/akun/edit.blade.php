@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-6" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ubah Jenis Pembayaran</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('akun.update', $data->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Akun</label>
                        <select class="form-control" name="jenis_akun" aria-label="Default select example">
                            <option selected value=""> --- Jenis Akun -- </option>
                            <option value="debit">Debit</option>
                            <option value="kredit">Kredit</option>
                        </select>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection