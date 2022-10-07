@extends('layouts.app')
@section('style')

@endsection
@section('content')
<div class="row">
    <div class="col-md-5">
        <form action="" method="GET">
            <div class="mb-3">
                <label class="form-label">Pilih Bulan Transaksi</label>
                <input type="month" name="bulan" class="form-control" value="{{ $_GET['bulan'] ?? Carbon\Carbon::now()->format('Y-m')}}">
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
                Cetak Jurnal Transaksi
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Jurnal Transaksi 
                    @if (isset($_GET['bulan']))
                        {{ Carbon\Carbon::createFromFormat('Y-m', $_GET['bulan'])->format('M Y') }}
                    @else
                        {{ Carbon\Carbon::parse(now())->format('M Y') }}
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No Bukti</th>
                        <th>Keterangan</th>
                        <th>Transaksi</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Aksi</th>
                    </tr>
                    @php($i = 1)
                    @php($no = 1)
                    @foreach ($data as $item)    
                        <tr>
                            @if ($i % 2 == 0)
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td  style="padding-left: 60px">
                                {{ $item->akun->nama }}
                            </td>

                            @else
                                <td>{{ $no }}</td>
                                <td>
                                    {{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>
                                <td>{{ $item->kode_transaksi }}</td>
                                <th><i>{{ $item->nama_transaksi }}</i></th>
                                <td>{{ $item->akun->nama }}</td>
                                @php($no++)
                            @endif
                            @if($item->debit == null)
                                <td></td>
                            @else
                                <td>Rp. {{ number_format($item->debit) }}</td>
                            @endif

                            @if($item->kredit == null)
                                <td></td>
                            @else
                                <td>Rp. {{ number_format($item->kredit) }}</td>
                            @endif

                            <td>
                            @if ($i % 2 == 0)
                            -
                            @else
                            <a href="{{ route('jenis-pembayaran.edit', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            @endif
                            </td>
                        </tr>
                        
                        @php($i++)
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection