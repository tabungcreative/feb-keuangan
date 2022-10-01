@extends('layouts.app')
@section('style')

@endsection
@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-12" id="detail-mhs">
        @foreach ($akun as $akunItem)
        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $akunItem->nama }}</h6>
            </div>
            <div class="card-body">
                    @php
                        $transaksi = App\Models\Transaksi::where('akun_id', $akunItem->id)->orderBy('tanggal', 'ASC')->get();                        
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
                        @if ($akunItem->isPendapatan)
                            @php($saldo += $item->kredit)
                            
                        @else
                            @php($saldo -= $item->kredit)
                        @endif
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
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
                    <tr class="font-weight-bold"> 
                        <td colspan="3">Total</td>
                        <td>Rp {{ number_format($totalDebit) }}</td>
                        <td>Rp {{ number_format($totalKredit) }}</td>
                        <td>-</td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection