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
                        Catatan Atas Laporan Keuagan
                        @if (isset($_GET['bulan']))
                            {{Carbon\Carbon::createFromFormat('Y-m',$_GET['bulan'])->format('F Y')}}
                        @else
                            {{ Carbon\Carbon::now()->format('F Y') }}
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" width="100%">
                            <tr>
                                <th>1. Posisi Kas :</th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th>2. Bank :</th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <td class="pl-4" colspan="2">Terdiri dari :</td>
                            </tr>
                            <tr>
                                <td class="pl-4" colspan="2">Tabungan :</td>
                            </tr>
                            <tr>
                                <td class="pl-4">Posisi pada (Oktober .. 2022) : </td>
                                <td><span class="float-right">Rp. 5000000</span></td>
                            </tr>
                            <tr>
                                <th class="pl-4">A. Bank BPD, Total tersimpan</th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th class="pl-5">Total Bank</th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th>3. Piutang tercatat sebesar Rp. 20000000 yang merupakan piutang karyawan di lingkungan fakultas </th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th>4. Aktiva Tetap </th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <td class="pl-4" colspan="2">Terdiri dari :</td>
                            </tr>
                            <tr>
                                <th class="pl-4">A. Peralatan Kantor (Harga Perolehan)</th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <td class="pl-5">Penyusutan sampai s.d Tahun 2022</td>
                                <td><span class="float-right">Rp. 5000000</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5">Nilai Buku</td>
                                <td><span class="float-right">Rp. 5000000</span></td>
                            </tr>
                            <tr>
                                <th class="pl-5" colspan="2">Penyusutan Menggunakan metode garis lurus selama 10 tahun</th>
                            </tr>
                            <tr>
                                <th>4. Modal Fakultas Ekonomi UNSIQ </th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <td class="pl-4">Modal pada 01 November 2022</td>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <td class="pl-4">Penambahan modal bulan November</td>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <td class="pl-4">Modal pada 31 November 2022</td>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th colspan="2">6. Pendapatan </th>
                            </tr>
                            <tr>
                                <td class="pl-4" colspan="2">Pendapatan Fakultas Ekonomi & Bisnis UNSIQ yang tercatat pada November 2022 sebesar Rp.20000 Terdiri dari :</td>
                            </tr>
                            <tr>
                                <td class="pl-4">a. Pendapatan Mahasiswa</td>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th colspan="2">7. Pengeluaran </th>
                            </tr>
                            <tr>
                                <td class="pl-4" colspan="2">Pendapatan Fakultas Ekonomi & Bisnis UNSIQ yang tercatat pada November 2022 sebesar Rp.20000 Terdiri dari :</td>
                            </tr>
                            <tr>
                                <td class="pl-4">a. Pendapatan Mahasiswa</td>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th colspan="2">8. Pendapatan Bunga Bank </th>
                            </tr>
                            <tr>
                                <td class="pl-4">Pendapatan Fakultas Ekonomi & Bisnis UNSIQ yang tercatat pada November 2022 sebesar Rp.20000 Terdiri dari :</td>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                            <tr>
                                <th>9. Pendapatan Lain-lain </th>
                                <th><span class="float-right">Rp. 5000000</span></th>
                            </tr>
                        </table>
{{--                        <ol class="font-weight-bold">--}}
{{--                            <li>Posisi Kas: </li>--}}
{{--                            <li>--}}
{{--                                Bank : <span class="float-right">Rp. 5000000</span><br>--}}
{{--                                Terdiri Dari <br>--}}
{{--                                Tabungan : <br>--}}
{{--                                Posisi pada (Oktober .. 2022) : <br>--}}
{{--                                <ul>--}}
{{--                                    <li>Bank BPD, Total tersimpan</li>--}}
{{--                                </ul>--}}

{{--                                Total Bank :--}}
{{--                            </li>--}}
{{--                            <li>Piutang tercatat sebesar Rp. 20000000 yang merupakan piutang karyawan di lingkungan fakultas  <span class="float-right">Rp. 5000000</span></li>--}}
{{--                            <li>--}}
{{--                                Aktiva Tetap <br>--}}
{{--                                Terdiri dari :--}}
{{--                                <ul>--}}
{{--                                    <li>--}}
{{--                                        Perlengkapan Kantor  <span class="float-right">Rp. 5000000</span> <br>--}}
{{--                                        Penyusutan s.d Tahun 2021  <span class="float-right">Rp. 5000000</span><br>--}}
{{--                                        Nilai Buku  <span class="float-right">Rp. 5000000</span><br>--}}
{{--                                        Penyusutan menggunakan metode garis lurus selama 20 tahun  <span class="float-right">Rp. 5000000</span>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                                Daftar Aktiva tetap dapat dilihat pada halaman tersendiri--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                Modal Fakultas Ekonomi dan Bisnis UNSIQ<br>--}}
{{--                                Modal pada 01 November 2022<br>--}}
{{--                                Penambahan Bulan November<br>--}}
{{--                                Modal pada 31 November 2022<br>--}}
{{--                            </li>--}}
{{--                            <li>--}}

{{--                            </li>--}}
{{--                        </ol>--}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
