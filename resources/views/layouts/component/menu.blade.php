<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

@can('bendahara')
<!-- Heading -->
<div class="sidebar-heading text-white">
    Pembayaran
</div>

<!-- Nav Item - Tables -->
<li class="nav-item {{ Route::is('jenis-pembayaran.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('jenis-pembayaran.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Jenis Pembayaran</span></a>
</li>

<li class="nav-item  {{ Route::is('pembayaran.*') ? 'active' : '' }}">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-credit-card"></i>
        <span>Pembayaran</span>
    </a>
    <div id="collapseTwo" class="collapse {{ Route::is('pembayaran.*') ? 'show' : '' }}" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Route::is('pembayaran.*') ? 'active' : '' }}" href="{{ route('pembayaran.get-cek-nim') }}">Pembayaran Mahasiswa</a>
            <a class="collapse-item {{ Route::is('pembayaran.index') ? 'active' : '' }}" href="{{ route('pembayaran.index') }}">Riwayat Pembayaran</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">


<div class="sidebar-heading text-white">
    Akuntansi
</div>
<!-- Nav Item - Tables -->
<li class="nav-item {{ Route::is('akun.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Akun</span></a>
</li>

<li class="nav-item {{ Route::is('transaksi.create') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('transaksi.create') }}">
        <i class="fas fa-credit-card"></i>
        <span>Tambah Transaksi</span></a>
</li>

<li class="nav-item {{ Route::is('transaksi.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('transaksi.index') }}">
        <i class="fas fa-book"></i>
        <span>Jurnal Transaksi</span></a>
</li>

<li class="nav-item" {{ Route::is('laporan-keuangan.buku-besar') ? 'active' : '' }}>
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#buku_besar" aria-expanded="true"
        aria-controls="buku_besar">
        <i class="fas fa-book-open"></i>
        <span>Buku Besar</span>
    </a>
    <div id="buku_besar" class="collapse" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" {{ Route::is('laporan-keuangan.buku-besar') ? 'active' : '' }} href="{{ route('laporan-keuangan.buku-besar') }}">Buku Besar</a>
            <a class="collapse-item " {{ Route::is('laporan-keuangan.index') ? 'active' : '' }} href="{{ route('laporan-keuangan.buku-besar-rinci') }}">Perincian Buku Besar</a>
        </div>
    </div>
</li>


<li class="nav-item {{ Route::is('laporan-keuangan.*') ? 'active' : '' }}" >
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#laporan_keuangan" aria-expanded="true"
        aria-controls="laporan_keuangan">
        <i class="fas fa-file-invoice-dollar"></i>
        <span>Laporan Keuangan</span>
    </a>
    <div id="laporan_keuangan" class="collapse {{ Route::is('laporan-keuangan.*') ? 'show' : '' }}" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Route::is('laporan-keuangan.perubahan-modal') ? 'active' : '' }}"  href="{{ route('laporan-keuangan.perubahan-modal') }}">Perubahan Modal</a>
            <a class="collapse-item " href="#">Catatan Atas Keuangan</a>
            <a class="collapse-item " href="#">Laporan Keuangan</a>
            <a class="collapse-item " href="#">Keuangan Neraca</a>
            <a class="collapse-item " href="#">Laba Rugi</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
@endcan

{{-- <!-- Heading -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Laporan</span></a>
</li> --}}


<div class="sidebar-heading text-white">
    Manajemen Inventaris
</div>

<li class="nav-item {{ Route::is('aktiva.index*') ? 'active' : '' }}">
    <a class="nav-link " href="{{ route('aktiva.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Laporan aktiva</span></a>
</li>

<li class="nav-item {{ Route::is('aktiva.create*') ? 'active' : '' }}">
    <a class="nav-link " href="{{ route('aktiva.create') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Tambah Aktiva</span></a>
</li>
