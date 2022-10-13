<?php

use App\Http\Controllers\Api\PembayaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(PembayaranController::class)
    ->as('pembayaran.')
    ->middleware('api-key')
    ->prefix('pembayaran')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{no_pembayaran}/no-pembayaran', 'showNoPembayaran')->name('show-no-pembayaran');
    });
