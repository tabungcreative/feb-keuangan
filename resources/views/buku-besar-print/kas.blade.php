@extends('layouts.pdf')

@section('content')
    @php($i = 0)
        @foreach ($akunKasJalan as $akun)
            <h3 class="m-0 font-weight-bold text-primary">Laporan Buku Besar {{ $akun->nama }} Bulan Sekarang</h3>
                <div class="card-body">
                    <table>
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
                            <th colspan="3">Total</th>
                            <th>Rp. {{ number_format($listTotalDebit[$i] + $listSaldoAwalKas[$i]) }},-</th>
                            <th>Rp. {{ number_format($listTotalKredit[$i]) }},-</th>
                            <th>Rp. {{ number_format($saldo) }},-</th>
                        </tr>
                    </table>
                </div>
            </div>
            @php($i++)
        @endforeach
@endsection
