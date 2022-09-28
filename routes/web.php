<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisPembayaranController;
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
    return view('welcome');
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
    });

Route::get('/authuser', function (Request $request) {

    $access_token = $request->session()->get('access_token');

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $access_token
    ])->get('https://accounts.feb-unsiq.ac.id/api/user');

    return $response->json();
});
