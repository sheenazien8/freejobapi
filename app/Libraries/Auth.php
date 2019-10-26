<?php
namespace App\Libraries;

use App\Models\User;
use Illuminate\Http\Request;

class Auth
{
    public static function user($request)
    {
        $token = $request->header('Authorization');
        $token = explode('Bearer ', $token)[1];

        $user = User::where('api_token', $token)->first();

        return $user;
    }
}
