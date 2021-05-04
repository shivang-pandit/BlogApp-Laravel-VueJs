<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        \Log::info('inside admin check middleware!');
        if(!Auth::check()) {               
            return response()->json([
                'error'=> 'You are not allowed to access this route!'
            ],422);    
        }

        $user = Auth::user();                
        if($user->role->is_admin == 0){
            return response()->json([
                'error'=> 'You are not allowed to access this route!'
            ],422);    
        }

        return $next($request);
    }
}
