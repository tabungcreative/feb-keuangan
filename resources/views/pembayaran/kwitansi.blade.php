<!DOCTYPE html>
<head>
    <title>Kwitansi - {{ $mahasiswa['nama'] }} - {{ $mahasiswa['nim'] }}</title>
    <meta charset="utf-8">
    <style>
        /* @page { size: 14cm 21cm portrait; } */
        /* @media print {
            body {transform: rotate(90deg);}
        } */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        #judul{
            text-align:center;
            margin: 10px 0px;
        }
        header {
            padding: 30px 30px 10px;
        }
        #halaman{
            width: 100%; 
            height: auto; 
            /* position: absolute;  */
            padding-left: 30px; 
            padding-right: 30px; 
            padding-bottom: 80px;
        }
        .terbilang {
            float: left;
            padding: 40px 20px;
        }
        .ttd {
            float: right;
            align-items: center;
            margin-right: 100px;
            text-align: center;
        }
        table td {
            padding: 10px;
        }
        footer {
            padding: 30px;
            position: relative;
            bottom: 0;
        }
    </style>

</head>

<body>

    <header>
        <img src="data:image/png;base64, {{ $kop }}" alt="Red dot" width="500px"/>
    </header>

    <div id=halaman>
        <h4 id="judul">KWITANSI</h4>

        <table width="100%">
            <tr>
                <td>No</td>
                <td>:</td>
                <td>{{ $pembayaran->no_pembayaran }}</td>
            </tr>
            <tr>
                <td>Telah terima dari</td>
                <td>:</td>
                <td>{{ $mahasiswa['nama'] }} / {{ $mahasiswa['nim'] }}</td>
            </tr>
            <tr>
                <td style="width: 30%; vertical-align: top;">Uang sebanyak</td>
                <td style="width: 5%; vertical-align: top;">:</td>
                <td><span style="font: italic small-caps bold 16px/30px Georgia, serif; border: 1px dashed black; padding: 5px 100px 5px 30px;">
                    {{ ucfirst(Riskihajar\Terbilang\Facades\Terbilang::make($pembayaran->jenisPembayaran->jumlah_bayar)) }} rupiah
                </span></td>
            </tr>
            <tr>
                <td>Guna membayar</td>
                <td>:</td>
                <td>{{ $pembayaran->jenisPembayaran->nama_pembayaran }}</td>
            </tr>
        </table>


        <div>
            <div class="terbilang">
                Terbilang &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="border: 1px solid black; padding: 5px 20px;">Rp. {{ number_format($pembayaran->jenisPembayaran->jumlah_bayar) }}</span>
            </div>
            <div class="ttd">
                <div>Wonosobo, {{ $tanggal }}</div>
                <div>Penerima</div><br><br>
                <div>Triana Rizki Kurniawati, S.E,</div>
            </div>
        </div>
        

    </div>
    <footer>
        <img src="data:image/png;base64, {{ $footerKop }}" alt="Red dot" width="100%"/>
    </footer>
</body>

</html>