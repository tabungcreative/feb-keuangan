<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TransaksiController;
use App\Models\Akun;
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
        Route::get('/callback', 'callback')->name('callback');
    });

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
    });

Route::controller(TransaksiController::class)
    ->prefix('transaksi')
    ->as('transaksi.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/create', 'create')->name('create');
        Route::get('/buku-besar', 'bukuBesar')->name('buku-besar');
    });



// Route::get('/authuser', function (Request $request) {

//     $access_token = $request->session()->get('access_token');

//     $response = Http::withHeaders([
//         'Accept' => 'application/json',
//         'Authorization' => 'Bearer ' . $access_token
//     ])->get('https://accounts.feb-unsiq.ac.id/api/user');

//     return $response->json();
// });
