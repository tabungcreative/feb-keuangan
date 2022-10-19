@extends('layouts.app')

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

            <div class="card shadow my-5">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">
                        Laporan Perubahan Modal Per
                        @if (isset($_GET['bulan']))
                            {{ Carbon\Carbon::createFromFormat('Y-m',$_GET['bulan'])->lastOfMonth()->format('d F Y') }}
                        @else
                            {{ Carbon\Carbon::now()->lastOfMonth()->format('d F Y') }}
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th width="60%">
                                Modal,
                                @if (isset($_GET['bulan']))
                                    {{ Carbon\Carbon::createFromFormat('Y-m',$_GET['bulan'])->firstOfMonth()->format('d F Y') }}
                                @else
                                    {{ Carbon\Carbon::now()->lastOfMonth()->format('d F Y') }}
                                @endif
                            </th>
                            <th width="40%">Rp. {{ number_format($modalAwal) }} </th>
                        </tr>
                        <tr>
                            <th width="60%">Penambahan Modal Bersih</th>
                            <th width="40%">Rp. {{ number_format($penambahanModalBersih) }} </th>
                        </tr>
                        <tr>
                            <th width="60%">
                                @if (isset($_GET['bulan']))
                                    {{ Carbon\Carbon::createFromFormat('Y-m',$_GET['bulan'])->lastOfMonth()->format('d F Y') }}
                                @else
                                    {{ Carbon\Carbon::now()->lastOfMonth()->format('d F Y') }}
                                @endif
                            </th>
                            <th width="40%">Rp. {{ number_format($modalAkhir) }} </th>
                        </tr>
                    </table>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
