@extends('layouts.app')
@section('style')
    <style>
        ol li {
            width: 1500px;
            margin-bottom: 10px;
        }
    </style>
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
            <div class="card shadow my-5">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">
                        Neraca
                        @if (isset($_GET['bulan']))
                            {{Carbon\Carbon::createFromFormat('Y-m',$_GET['bulan'])->format('F Y')}}
                        @else
                            {{ Carbon\Carbon::now()->format('F Y') }}
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="m-0 font-weight-bold text-primary my-4">Activa Lancar</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>Kas</td>
                                <td>Rp. {{ number_format($totalKas) }}</td>
                            </tr>
                            <tr>
                                <td>Bank</td>
                                <td>Rp. {{ number_format($totalBank) }}</td>
                            </tr>
                            <tr>
                                <td>Piutang</td>
                                <td>Rp. {{ number_format($totalPiutang) }}</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>Rp. {{ number_format($totalAktivaLancar) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
