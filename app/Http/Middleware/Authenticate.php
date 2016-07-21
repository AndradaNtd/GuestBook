<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
//    public function handle($request, Closure $next, $guard = null)
//    {
//
//        if (Auth::guard($guard)->guest()) {
//            if ($request->ajax() || $request->wantsJson()) {
//                dd(2);
//                return response('Unauthorized.', 401);
//            }
//
//            return redirect()->guest('login');
//        }
//        dd(2);
//
//        return $next($request);
//    }
    public function handle($request, Closure $next, $guard = null){
        $api = new ApiController();
        if (!Auth::guard($guard)->guest()) {
            return $next($request);
        }
        return $api->respondUnauthorized(["general"=>["Unauthorized request"]]);
    }
}
