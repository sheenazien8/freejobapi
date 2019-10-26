<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 401);
        }
        $token = explode('Bearer ', $token)[1];

        $user = User::where('api_token', $token)->first();
        if ($user) {
            $carbon = new Carbon();
            $nowTime = $carbon->now()->format('Y-m-d H:i:s');
            $checkExpiredToken = $user->expired_token < $nowTime;
            // jika benar salah
            if (!$checkExpiredToken) {
                return $next($request);
            }else {
                return response()->json([
                    'message' => 'Token Expired',
                    'success' => false
                ]);
            }
        }else {
            return response()->json([
                'message' => 'Token Is Not Valid',
                'success' => false
            ], 401);
        }
    }
}
