<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Check if the user is authenticated and is an admin
        if(Auth::guard('api')->check() && Auth::guard('api')->user()->is_admin)
            // If authenticated and admin, pass the request to the next middleware
            return $next($request);

        // If not authenticated or not admin, return a 403 Forbidden response
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
