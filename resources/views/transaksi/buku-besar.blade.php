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
        @foreach ($akun as $akunItem)
        <hr>
        <div class="card shadow my-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $akunItem->nama }}</h6>
            </div>
            <div class="card-body">
                    @php
                        $transaksi = App\Models\Transaksi::where('akun_id', $akunItem->id)
                            ->whereMonth('tanggal', Carbon\Carbon::now()->month)
                            ->whereYear('tanggal', Carbon\Carbon::now()->year)
                            ->orderBy('tanggal', 'ASC')->get();
                        $transaksiBulanLalu = App\Models\Transaksi::where('akun_id', $akunItem->id)
                        ->whereMonth('tanggal', Carbon\Carbon::now()->subMonth(1)->month)
                        ->whereYear('tanggal', Carbon\Carbon::now()->year)
                        ->get();

                        if (isset($_GET['bulan'])) {
                            $transaksi = App\Models\Transaksi::where('akun_id', $akunItem->id)
                            ->whereMonth('tanggal', Carbon\Carbon::createFromFormat('Y-m', $_GET['bulan'])->month)
                            ->whereYear('tanggal', Carbon\Carbon::createFromFormat('Y-m', $_GET['bulan'])->year)
                            ->orderBy('tanggal', 'ASC')->get();

                            $transaksiBulanLalu = App\Models\Transaksi::where('akun_id', $akunItem->id)
                            ->whereMonth('tanggal', Carbon\Carbon::createFromFormat('Y-m', $_GET['bulan'])->subMonth(1)->month)
                            ->whereYear('tanggal', Carbon\Carbon::createFromFormat('Y-m', $_GET['bulan'])->year)
                            ->get();
                        }

                        $saldoDebit = 0;
                        $saldoKredit = 0;
                        
                        foreach ($transaksiBulanLalu as $value) {
                            $saldoDebit += $value->debit;
                            $saldoKredit += $value->kredit;
                        }

                        $saldoAwalBulanLalu = $saldoDebit - $saldoKredit;
                    @endphp
                    <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Saldo</th>
                    </tr>
                    @php($i = 1)
                    @php($totalDebit = $saldoAwalBulanLalu)
                    @php($totalKredit = 0)
                    @php($saldo = $saldoAwalBulanLalu)

                    <tr class="font-weight-bold">
                        <th colspan="3">Saldo Awal</th>
                        <td>Rp {{ number_format($saldoAwalBulanLalu) }}</td>
                        <td>Rp 0 </td>
                        <td>Rp. {{ number_format($saldo) }}</td>
                    </tr>
                    @foreach ($transaksi as $item)                     
                        @php($transaksi = App\Models\Transaksi::where('kode_transaksi' , $item->kode_transaksi)->where('akun_id', '!=', $akunItem->id)->first())
                        @php($akun = App\Models\Akun::where('id' , $transaksi->akun_id)->first())
                        @php($saldo += $item->debit)
                        @if ($akunItem->akun_kas == 'kas_masuk')
                            @php($saldo += $item->kredit)
                        @else
                            @php($saldo -= $item->kredit)
                        @endif
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>
                            <td>{{ $akun->nama }}</td>
                            <td>Rp. {{ number_format($item->debit) }}</td>
                            <td>Rp. {{ number_format($item->kredit) }}</td>
                            <td>Rp. {{ number_format($saldo) }}</td>

                        </tr>
                        @php($totalDebit += $item->debit)
                        @php($totalKredit += $item->kredit)
                        @php($i++)
                    @endforeach
                    <tr class="font-weight-bold"> 
                        <td colspan="3">Total</td>
                        <td>Rp {{ number_format($totalDebit) }}</td>
                        <td>Rp {{ number_format($totalKredit) }}</td>
                        <td>Rp {{ number_format($totalDebit - $totalKredit) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection