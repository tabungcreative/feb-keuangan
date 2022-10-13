@extends('layouts.app')
@section('style')

@endsection
@section('content')
<div class="row">
    <div class="col-md-5">
        <form action="" method="GET">
            <div class="mb-3">
                <label class="form-label">Pilih Tahun Laporan Aktiva</label>
                <input type="number" min="1900" max="2099" name="tahun" class="form-control" value="{{ $_GET['tahun'] ?? Carbon\Carbon::now()->format('Y')}}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-12" id="detail-mhs">
        <div class="row container my-3">
            <a href="" class="btn btn-success">
                <i class="fas fa-download"></i>
                Cetak Laporan Aktiva
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Laporan Aktiva Tahun
                    @if (isset($_GET['tahun']))
                        {{ Carbon\Carbon::createFromFormat('Y-m', $_GET['tahun'])->format('Y') }}
                    @else
                        {{ Carbon\Carbon::parse(now())->format('Y') }}
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Nama Aktiva</th>
                        <th>Tanggal Perolehan</th>
                        <th>Harga Perolehan</th>
                        <th>Penyusutan per tahun</th>
                        <th>Penyusutan per hari</th>
                        <th>Total Penyusutan</th>
                        <th>Nilai Buku</th>
                        <th>Aksi</th>
                    </tr>
                    @php($i = 1)
                    @php($no = 1)
                    @foreach ($aktiva as $data) 
                    @php($penyusutanPerTahun = ($data->harga_perolehan*20/100))
                    @php($penyusutanSdHariIni = Carbon\Carbon::now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal_perolehan)))
                    @php($totalPenyusutan = $penyusutanPerTahun * $penyusutanSdHariIni)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{ $data->nama_aktiva}}</td>
                            <td>{{ Carbon\Carbon::parse($data->tanggal_perolehan)->format('d M Y') }}</td>
                            <td>Rp. {{number_format($data->harga_perolehan)}}</td>
                            <td>Rp. {{number_format($penyusutanPerTahun)}}</td>
                            <td>Rp. {{round($data->penyusutan_perhari)}}/hari</td>
                            <td>{{ $totalPenyusutan }}</td>
                            <td>{{$data->harga_perolehan - $totalPenyusutan}}</td>
                            <td>
                                <a href="{{ route('jenis-pembayaran.edit', $data->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>  
                        {{-- <tr>
                            @if ($i % 2 == 0)
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td  style="padding-left: 60px">
                                {{ $data->nama }}
                            </td>

                            @else
                                <td>{{ $no }}</td>
                                <td>
                                    {{ Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}
                                </td>
                                <td>{{ $data->kode_transaksi }}</td>
                                <th><i>{{ $data->nama_transaksi }}</i></th>
                                <td>{{ $data->nama }}</td>
                                @php($no++)
                            @endif
                            @if($data->debit == null)
                                <td></td>
                            @else
                                <td>Rp. {{ number_format($data->debit) }}</td>
                            @endif

                            @if($data->kredit == null)
                                <td></td>
                            @else
                                <td>Rp. {{ number_format($data->kredit) }}</td>
                            @endif

                            <td>
                            @if ($i % 2 == 0)
                            -
                            @else
                            <a href="{{ route('jenis-pembayaran.edit', $data->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            @endif
                            </td>
                        </tr> --}}
                        
                        @php($i++)
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection