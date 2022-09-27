<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/login', function (Request $request) {
    
    if ($request->session()->get('access_token') != null) {
        return redirect()->back();
    }
    $state = Str::random(40);
    $request->session()->put("state", $state);
    $query = http_build_query([
        'client_id' => env('CLIENT_ID'),
        'redirect_uri' => env('REDIRECT_AUTH_URI'),
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
    ]);

    return redirect('https://accounts.feb-unsiq.ac.id/oauth/authorize?' . $query);
});

Route::get('/callback', function(Request $request) {
    $state = $request->get('state');

    throw_unless(strlen($state) > 0 && $state == $request->state, InvalidArgumentException::class);

    $response = Http::asForm()->post('https://accounts.feb-unsiq.ac.id/oauth/token', [
            'grant_type' => 'authorization_code', 
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'redirect_uri' => env('REDIRECT_AUTH_URI'),
            'code' => $request->code
        ]
    );
    $request->session()->put($response->json());
    return redirect('/authuser');
});

Route::get('/authuser', function(Request $request) {
    $access_token = $request->session()->get('access_token');

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer '. $access_token
    ])->get('https://accounts.feb-unsiq.ac.id/api/user');

    return $response->json();
});

Route::get('/logout', function(Request $request) {
    $request->session()->forget('access_token');
    $request->session()->forget('refresh_token');

    return redirect('/');
});