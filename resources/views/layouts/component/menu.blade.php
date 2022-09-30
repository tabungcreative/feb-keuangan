<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
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


<div class="sidebar-heading">
    Akuntansi
</div>
<!-- Nav Item - Tables -->
<li class="nav-item {{ Route::is('akun.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Akun</span></a>
</li>

<li class="nav-item  {{ Route::is('transaksi.*') ? 'active' : '' }}">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#transaksi" aria-expanded="true"
        aria-controls="transaksi">
        <i class="fas fa-credit-card"></i>
        <span>Transaksi</span>
    </a>
    <div id="transaksi" class="collapse {{ Route::is('transaksi.*') ? 'show' : '' }}" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Route::is('transaksi.create') ? 'active' : '' }}" href="{{ route('transaksi.create') }}">Tambah Transaksi</a>
            <a class="collapse-item {{ Route::is('transaksi.index') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">Jurnal Transaksi</a>
        </div>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('transaksi.buku-besar') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Buku Besar</span></a>
</li>

{{-- <!-- Heading -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Laporan</span></a>
</li> --}}

<div class="sidebar-heading">
    Manajemen Aset
</div>

<li class="nav-item">
    <a class="nav-link" href="{{ route('akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Aset Masuk</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Aset Keluar</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Status Aset</span></a>
</li>
