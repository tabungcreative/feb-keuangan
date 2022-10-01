@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
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
                </table>
            </div>
        </div>
        <div class="card shadow border-0 my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pembayaran</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pembayaran.store') }}">
                    @csrf
                    <input type="hidden" name="nim" value="{{ $mahasiswa['nim'] }}">
                    <div class="mb-3">
                        <label class="form-label">Jenis Pembayaran</label>
                        <select name="jenis_pembayaran_id" class="form-control">
                            <option value="">-- Pilih Jenis Pembayaran--</option>
                            @foreach ($jenisPembayaran as $value)  
                                <option value="{{ $value->id }}"> {{$value->nama}} --> Rp. {{ number_format($value->jumlah_bayar)  }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Akun Debit</label>
                        <select name="akun_debit_id" class="form-control select2" style="width: 100%">
                            <option value="">Pilih Akun Debit</option>
                            @foreach ($akunPendapatan as $value)  
                                <option value="{{ $value->id }}"> {{$value->nama}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Akun Kredit</label>
                        <select name="akun_kredit_id" class="form-control select2" style="width: 100%">
                            <option value="">Pilih Akun Kredit</option>
                            @foreach ($akun as $value)  
                                <option value="{{ $value->id }}"> {{$value->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Bayar</button>
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