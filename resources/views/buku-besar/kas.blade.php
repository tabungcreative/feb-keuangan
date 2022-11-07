@extends('layouts.app')
@section('style')

@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <form action="" method="GET">
                <div class="mb-3">
                    <label class="form-label">Pilih Bulan Transaksi</label>
                    <input type="month" name="year_month" class="form-control" value="{{ $_GET['year_month'] ?? Carbon\Carbon::now()->format('Y-m')}}">
               </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Akun</label>
                    <select class="form-control" name="akun_id">
                        <option value="">-- Pilih Akun --</option>
                        @foreach($listAkun as $akun)
                            <option value="{{ $akun->id }}" {{$akun->id == ($_GET['akun_id'] ?? 0) ? 'selected' : '' }}>{{ $akun->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="row d-flex justify-content-left my-4">
        <div class="col-md-12" id="detail-mhs">
            @php($i = 0)
            @foreach ($akunKasJalan as $akun)
                <hr>
                <div class="card shadow my-5">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $akun->nama }}</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                            <tr class="font-weight-bold">
                                <th colspan="3">Saldo Awal</th>
                                <td>Rp {{ number_format($listSaldoAwalKas[$i]) }}</td>
                                <td>Rp 0 </td>
                                <td>Rp. {{ number_format($listSaldoAwalKas[$i]) }}</td>
                            </tr>

                            @php($no = 1)
                            @php($transaksi = $listTransaksi[$i])
                            @php($saldo = $listSaldoAwalKas[$i])
                            @foreach ($transaksi as $item)
                                @php($saldo += $item->debit)
                                @php($saldo -= $item->kredit)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->nama_transaksi }}</td>
                                    <td>Rp. {{ number_format($item->debit) }},-</td>
                                    <td>Rp. {{ number_format($item->kredit) }},-</td>
                                    <td>Rp. {{ number_format($saldo) }},-</td>
                                </tr>
                                @php($no++)
                            @endforeach
                            <tr class="font-weight-bold">
                                <td colspan="3">Total</td>
                                <td>Rp. {{ number_format($listTotalDebit[$i] + $listSaldoAwalKas[$i]) }},-</td>
                                <td>Rp. {{ number_format($listTotalKredit[$i]) }},-</td>
                                <td>Rp. {{ number_format($saldo) }},-</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @php($i++)
            @endforeach
        </div>
    </div>
@endsection
