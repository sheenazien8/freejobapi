<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $request->request->add([
            'password' => app('hash')->make($request->password)
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->save();

        return response()->json([
            'message' => 'Success Create User '. $user->username,
            'data' => $user,
            'success' => true
        ]);
    }

    public function login(Request $request)
    {
        $carbon = new Carbon();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->username)->first();
        if ($user) {
            $token = $this->generateToken();
            $expired_token = $carbon->now()->addHours(1)->format('Y-m-d H:i:s');
            $checkPassword = app('hash')->check($request->password, $user->password);
            if ($checkPassword) {
                $user->api_token = $token;
                $user->expired_token = $expired_token;
                $user->save();

                return response()->json([
                    'message' => 'OK',
                    'data' => $user,
                    'success' => true
                ]);
            }
        }else {
            return response()->json([
                'message' => 'Username not found',
                'success' => false
            ], 401);
        }
    }

    private function generateToken($length = 120)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
