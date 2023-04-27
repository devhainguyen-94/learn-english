<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Constant;
class CheckRoleAdmin
{
    const ROLE_ADMIN = 0 ;
    const ROLE_CLIENT = 1;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if($user->role === Constant::ROLE_ADMIN ){
            return $next($request);
        }
        return response()->json([
            'status_code' => 500,
            'message' => 'You are not Admin',
        ]);
    }
}
