<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoreLastUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle($request, Closure $next)
    // {
    //     // Store the current URL if the user is not authenticated
    //     if (!Auth::check() && !$request->is('login') && !$request->isMethod('ajax')) {
    //         // Store the intended URL in the session
    //         session(['url.intended' => $request->fullUrl()]);
    //     }

    //     // Continue processing the request
    //     return $next($request);
    // }
}
