<?php

namespace App\Helper;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Session;

class AuthUser
{
    public static function user()
    {
        $token = Session::get('access_token');

        $tokenParts = explode(".", $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);

        dd($jwtPayload->user);
    }

    public static function accessToken()
    {
        return Session::get('access_token');
    }
}
