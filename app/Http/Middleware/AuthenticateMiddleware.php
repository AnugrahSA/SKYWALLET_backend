<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     */

     public function handle($request, Closure $next)
     {
        $token = session()->get('token_key');

        if($token == null){
            return redirect()->route('landing')->with('failed_message', 'Your session time is expired. Please login again!');
        }

        return $next($request);
     }
}