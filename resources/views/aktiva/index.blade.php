@extends('layouts.app')
@section('style')

@endsection
@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-12" id="detail-mhs">
        <div class="row container my-3">
            <a href="{{ route('aktiva.create') }}" class="btn btn-primary mr-2">
                <i class="fas fa-plus-circle"></i>
                Tambah Inventaris
            </a>
            <a href="" class="btn btn-success">
                <i class="fas fa-download"></i>
                Cetak Laporan Aktiva
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Aktiva Tahun
                    @if (isset($_GET['tahun']))
                        {{ Carbon\Carbon::createFromFormat('Y-m', $_GET['tahun'])->format('Y') }}
                    @else
                        {{ Carbon\Carbon::parse(now())->format('Y') }}
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No</th>
                            <th>Nama Aktiva</th>
                            <th>Kategori</th>
                            <th>Tanggal Perolehan</th>
                            <th>Harga Perolehan</th>
                            <th>Umur Ekonomis</th>
                            <th>Penyusutan per tahun</th>
                            <th>Penyusutan per hari</th>
                            <th>Total Penyusutan s/d Hari ini</th>
                            <th>Nilai Buku</th>
                            <th>Aksi</th>
                        </tr>
                        @php($i = 1)
                        @php($no = 1)
                        @foreach ($aktiva as $data)
                            @php($penyusutanPerTahun = ($data->harga_perolehan*20/100))
                            @php($penyusutanSdHariIni = Carbon\Carbon::now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal_perolehan)))
                            @php($totalPenyusutan = $data->penyusutan_perhari * $penyusutanSdHariIni)
                            @php($nilaiBuku = $data->harga_perolehan - $totalPenyusutan)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{ $data->nama_aktiva}}</td>
                                <td>
                                    @if($data->kategori == 'peralatan')
                                        <span class="badge badge-success">{{ $data->kategori}}</span>
                                    @elseif($data->kategori == 'perlengkapan')
                                        <span class="badge badge-primary">{{ $data->kategori}}</span>
                                    @else
                                        <span class="badge badge-info">{{ $data->kategori}}</span>
                                    @endif
                                </td>
                                <td>{{ Carbon\Carbon::parse($data->tanggal_perolehan)->format('d M Y') }}</td>
                                <td>Rp. {{number_format($data->harga_perolehan)}}</td>
                                <td>{{number_format($data->umur_ekonomis)}} Tahun</td>
                                <th>Rp. {{number_format($penyusutanPerTahun)}}</th>
                                <th>Rp. {{number_format($data->penyusutan_perhari)}}/hari</th>
                                <th>Rp. {{ number_format($totalPenyusutan) }}</th>
                                <th>
                                    @if($nilaiBuku <= 0)
                                        0
                                    @else
                                        Rp. {{ number_format($nilaiBuku) }}
                                    @endif
                                </th>
                                <td>
                                    <a href="{{ route('aktiva.edit', $data->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="container-fluid my-5">
                    <h5 class="m-0 font-weight-bold text-primary float-right">
                        Total Keseluruhan Aktiva Sesudah Penyusutan : Rp. {{ number_format($totalAkhirAktiva) }}
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
