<?php

namespace App\Http\Middleware;

use App\Libraries\Auth;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Closure;

class CheckRoleUser
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
        $auth = Auth::user($request);
        $checkrole = $auth->userable instanceof Company;
        if ($checkrole) {
            return $next($request);
        }else {
            return response()->json([
                'message' => 'Page Is Forbidden',
                'success' => false
            ], 403);
        }
    }
}
