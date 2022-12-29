@extends('layouts.pdf')

@section('style')
<style>
    .isi{
        margin-left:1cm; 
    }
    .isi p{
        margin: 0;
    }

    .ttd {
        float: right;
        align-items: center;
        margin-right: 100px;
        text-align: center;
    }

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
<div id="halaman">
        <h4 class="m-0 font-weight-bold text-primary">
            BERITA ACARACA PENGHAPUSAN ASET<br>
            FAKULTAS EKONOMI DAN BISNIS (FEB)<br> 
            UNIVERSITAS SAINS AL-QURAN (UNSIQ)<br> 
            JAWA TENGAH DI INDONESIA<br> 
        </h4>
        <h4 class="m-0 font-weight-semibold text-primary">
            Nomor: ..../PA/FEB-UNSIQ/..../20... 
        </h4>
        
        <div class="isi">
            <p>Assalamu’alaikumWr. Wb.</p>
            <p style="text-indent: 1cm;text-align: justify;">
                Dalam rangka tata tertib administrasi pengelolaan barang milik Fakultas Ekonomi dan Bisnis (FEB) Universitas Sains Al-Qur'an (UNSIQ) Jawa Tengah di Wonosobo, setelah melalui pemeriksaan dan pertimbagan dekanat beberapa asset yang sudah tidak layak untuk digunakan dan perlu dihapuskan/dihibahkan/dijual dengan rincian sebagai berikut: 
            </p>
            <br>
           
            <table style="border: 1px solid black !important;">
                <tr>
                    <th>No</th>
                    <th>Kode Aktiva</th>
                    <th>Nama Aktiva</th>
                    <th>Tanggal Pembelian</th>
                    <th>Unit</th>
                    <th>Harga Perolehan</th>
                    <th>Nilai Buku</th>
                    <th>Nama Pemakai</th>
                    <th>Keterangan Aset</th>
                </tr>
               
                    <tr>
                        @php($penyusutanPerTahun = ($aktiva->harga_perolehan / $aktiva->umur_ekonomis))
                        @php($penyusutanSdHariIni = Carbon\Carbon::now()->diffInDays(Carbon\Carbon::createFromFormat('Y-m-d', $aktiva->tanggal_perolehan)))
                        @php($totalPenyusutan = $aktiva->penyusutan_perhari * $penyusutanSdHariIni)
                        @php($nilaiBuku = $aktiva->harga_perolehan - $totalPenyusutan)

                        <td>1</td>
                        <td>{{ $aktiva->kode_aktiva }}</td>
                        <td>{{ $aktiva->nama_aktiva}}</td>
                        <td>{{ Carbon\Carbon::parse($aktiva->tanggal_perolehan)->format('d M Y') }}</td>
                        <td>{{ $aktiva->jumlah }}</td>
                        <td>Rp. {{number_format($aktiva->harga_perolehan)}}</td>
                        <td>
                            @if($nilaiBuku <= 0)
                                0
                            @else
                                Rp. {{ number_format($nilaiBuku) }}
                            @endif
                        </td>
                        <td>
                            Fakultas
                        </td>
                        <td>

                        </td>
                    </tr>
            </table> 
            <p style="text-indent: 1cm;text-align: justify;">
                Sebagai bahan bukti terlampir foto/dokumen asset tersebut.
            </p>
        
            
            <p style="text-indent: 1cm;text-align: justify;">
                Demikian berita acara ini dibuat dengan sebenar-benarnya untuk dapat depergunakan dan ditindak lanjuti sebagaimana mestinya, terimakasih atas perhatian dan kerjasamanya.
            </p>
            <br>

            <p>Wassalamu’alaikum Wr.Wb.</p>
            <br>
            <div class="ttd">
                <div>Wonosobo, {{ $tanggal }}</div>
                <div>Dekan Fakultas Ekonomi dan Bisnis</div><br><br><br>
                <p style="font-weight: 500;">Dr. M. Elfan Kaukab, S.E. M.M., M.H.I.,</p>
                <p style="font-weight: 500;">NPU. 1910602045</p>
            </div>
        </div>
        
    </div>


@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection