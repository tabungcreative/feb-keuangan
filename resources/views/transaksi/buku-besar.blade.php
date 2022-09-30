@extends('layouts.app')
@section('style')

@endsection
@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-12" id="detail-mhs">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Jurnal Transaksi</h6>
            </div>
            <div class="card-body">

                @foreach ($akun as $akunItem)
                    <h6 class="m-0 font-weight-bold text-primary mt-5 mb-3">Buku Besar {{ $akunItem->nama }}</h6>

                    @php
                        $transaksi = App\Models\Transaksi::where('akun_id', $akunItem->id)->orderBy('created_at', 'ASC')->get();                        
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
                    @php($totalDebit = 0)
                    @php($totalKredit = 0)
                    @php($saldo = $akunItem->saldo)

                     <tr class="font-weight-bold">
                        <th colspan="3">Saldo Awal</th>
                        <td>Rp {{ number_format($akunItem->saldo) }}</td>
                        <td>Rp 0 </td>
                        <td>Rp. {{ number_format($saldo) }}</td>
                    </tr>
                    @foreach ($transaksi as $item) 
                        @php($saldo += $item->debit)
                        @php($saldo -= $item->kredit)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                                @if ($i % 2 == 0)
                                    -
                                @else
                                    {{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                @endif
                            </td>
                            <td>{{ $item->akun->nama }}</td>
                            <td>Rp. {{ number_format($item->debit) }}</td>
                            <td>Rp. {{ number_format($item->kredit) }}</td>
                            <td>Rp. {{ number_format($saldo) }}</td>

                        </tr>
                        @php($totalDebit += $item->debit)
                        @php($totalKredit += $item->kredit)
                        @php($i++)
                    @endforeach
                    <tr>
                        <th colspan="3">Total</th>
                        <td>Rp {{ number_format($totalDebit) }}</td>
                        <td>Rp {{ number_format($totalKredit) }}</td>
                        <td>-</td>
                    </tr>
                </table>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection