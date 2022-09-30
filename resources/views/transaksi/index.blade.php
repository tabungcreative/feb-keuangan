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
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Aksi</th>
                    </tr>
                    @php($i = 1)
                    @foreach ($data as $item)    
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

                            <td>
                                <a href="{{ route('jenis-pembayaran.edit', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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