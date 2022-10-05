@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-6" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pembayaran</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <th scope="col">No Pembayaran</th>
                        <td scope="col">{{ $pembayaran->no_pembayaran }}</td>
                    </tr>
                    <tr>
                        <th scope="col">NIM</th>
                        <td scope="col">{{ $mahasiswa['nim'] }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Nama</th>
                        <td scope="col">{{ $mahasiswa['nama'] }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Prodi</th>
                        <td scope="col">{{ $mahasiswa['prodi'] }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Guna Membayar</th>
                        <td scope="col">{{ $pembayaran->jenisPembayaran->nama }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Jumlah</th>
                        <td scope="col">Rp. {{ number_format($pembayaran->jenisPembayaran->jumlah_bayar) }}</td>
                    </tr>
                </table>
                <a href="{{ route('pembayaran.cetak-kwitansi', $pembayaran->id) }}" target="_blank" class="btn btn-sm btn-success">Cetak Kwitansi</a>
            </div>
        </div>
    </div>
</div>
@endsection