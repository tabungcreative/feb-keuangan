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

{{-- <li class="nav-item active">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-credit-card"></i>
        <span>Pembayaran Mahasiswa</span>
    </a>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item active" href="{{ route('admin.pembayaran.cekNim') }}">Pembayaran Mahasiswa</a>
            <a class="collapse-item" href="{{ route('admin.pembayaran.cekNim') }}">Riwayat Pembayaran</a>
        </div>
    </div>
</li> --}}

{{-- <!-- Heading -->
<div class="sidebar-heading">
    Akuntansi
</div>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Akun</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Transaksi</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Buku Besar</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.akun.index') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Laporan</span></a>
</li> --}}