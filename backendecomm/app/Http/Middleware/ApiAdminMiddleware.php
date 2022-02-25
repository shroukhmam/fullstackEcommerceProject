<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAdminMiddleware
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
        
        if(Auth::check()){
            if(auth()->user()->tokenCan('server:admin')){
                return $next($request);
            }else{
                 return response()->json([
                    'message'=>'Access Denied.! As You Are Not Admin'
                 ],403);
            }
        }else{
            return response()->json([
                'message'=>'need to login',
                'status'=>401
             ]);
        }
    }
}
