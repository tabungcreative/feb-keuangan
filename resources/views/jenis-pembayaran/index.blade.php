@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-6" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Jenis Pembayaran</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Kode Pembayaran</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                    @foreach ($data as $item)    
                        <tr>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>Rp. {{ number_format($item->jumlah_bayar) }}</td>
                            <td>
                                <a href="{{ route('jenis-pembayaran.edit', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Jenis Pembayaran</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('jenis-pembayaran.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis Pembayaran</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Pembayaran</label>
                        <input type="text" name="kode" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah_bayar" class="form-control">
                    </div>
                
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection