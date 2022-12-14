@extends('layouts.pdf')

@section('style')
    <style>
         table {
        border: 1px solid black;
    }

    
    table tr {
        border: 1px solid black;
    }

    table th {
        border: 1px solid black;
    }
    
    table tr td{
        border: 1px solid black;
    }
    </style>
@endsection
@section('content')
    <h4>Jurnal Transaksi Bulan Sekarang</h4>
    <table style="border: 1px solid black !important">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No Bukti</th>
            <th>Keterangan</th>
            <th>Transaksi</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
        @php($i = 1)
        @php($no = 1)
        @foreach ($transaksi as $item)
            <tr>
                @if ($i % 2 == 0)

                    <td  style="padding-left: 60px">
                        {{ $item->akun->nama }}
                    </td>

                @else
                    <td rowspan="2">{{ $no }}</td>
                    <td rowspan="2">
                        {{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td rowspan="2">{{ $item->kode_transaksi }}</td>
                    <th rowspan="2"><i>{{ $item->nama_transaksi }}</i></th>
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
            </tr>

            @php($i++)
        @endforeach
    </table>
@endsection
