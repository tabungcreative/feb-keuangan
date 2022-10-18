<?php

use App\Helper\AuthUser;
use App\Http\Controllers\AktivaController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('auth/login');
});

Route::controller(AuthController::class)
    ->prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/callback', 'callback')->name('callback');
    });

Route::middleware('custom-auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(JenisPembayaranController::class)
        ->prefix('jenis-pembayaran')
        ->as('jenis-pembayaran.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
        });


    Route::controller(AkunController::class)
        ->prefix('akun')
        ->as('akun.')
        ->middleware(['can:bendahara'])
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::post('/update-saldo', 'updateSaldo')->name('update-saldo');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
        });

    Route::controller(PembayaranController::class)
        ->prefix('pembayaran')
        ->as('pembayaran.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/cek/nim', 'getCekNim')->name('get-cek-nim');
            Route::post('/cek/nim', 'postCekNim')->name('post-cek-nim');
            Route::get('/{nim}/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/detail', 'detail')->name('detail');
            Route::get('/{id}/cetak-kwitansi', 'cetakKwitansi')->name('cetak-kwitansi');
        });

    Route::controller(TransaksiController::class)
        ->prefix('transaksi')
        ->as('transaksi.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
        });

    Route::controller(BukuBesarController::class)
        ->prefix('buku-besar')
        ->as('buku-besar.')
        ->group(function () {
            Route::get('/kas', 'kas')->name('kas');
            Route::get('/biaya', 'biaya')->name('biaya');
            Route::get('/pendapatan', 'pendapatan')->name('pendapatan');
        });

    Route::controller(LaporanKeuanganController::class)
        ->prefix('laporan-keungan')
        ->as('laporan-keuangan.')
        ->group(function () {
            Route::get('/buku-besar', 'bukuBesar')->name('buku-besar');
            Route::get('/buku-besar-rinci', 'bukuBesarRinci')->name('buku-besar-rinci');
            Route::get('/perubahan-modal', 'perubahanModal')->name('perubahan-modal');
            Route::get('/catatan-atas-keuangan', 'catatanAtasKeuangan')->name('catatan-atas-keuangan');
            Route::get('/laporan-keuangan', 'laporanKeuangan')->name('laporan-keuangan');
            Route::get('/keuangan-neraca', 'keuangan-neraca')->name('keuangan-nerace');
            Route::get('/laba-rugi', 'labaRugi')->name('laba-rugi');
        });

    Route::controller(AktivaController::class)
        ->prefix('aktiva')
        ->as('aktiva.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah-aktiva', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
        });
});



Route::get('/test', function (Request $request) {

    $user = AuthUser::user();

    return in_array('super-admin', $user->roles);

    dd($user->roles);

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . AuthUser::accessToken()
    ])->get('https://accounts.feb-unsiq.ac.id/api/user');

    return $response->json();
});
