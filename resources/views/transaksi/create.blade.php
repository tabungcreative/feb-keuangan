@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-12" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('transaksi.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" name="kode_transaksi" class="form-control">
                    </div>
                
                    <div class="mb-3">
                        <label class="form-label">Akun Debit</label>
                        <select name="akun_debit_id" class="form-control">
                            <option value="">-- Pilih Akun Debit--</option>
                            @foreach ($akun as $value)  
                                <option value="{{ $value->id }}"> {{$value->nama}} --> Rp. {{ number_format($value->saldo)  }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Akun Kredit</label>
                        <select name="akun_kredit_id" class="form-control">
                            <option value="">-- Pilih Akun Kredit--</option>
                            @foreach ($akun as $value)  
                                <option value="{{ $value->id }}"> {{$value->nama}} --> Rp. {{ number_format($value->saldo)  }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Jumlah Transaksi</label>
                        <input type="number" name="jumlah_transaksi" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection