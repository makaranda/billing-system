<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SetSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Get the session timeout from the authenticated user
            $sessionTimeout = Auth::user()->session_timeout;

            //Log::info('Session timeout for user: ' . $sessionTimeout);
            // Override the session lifetime configuration
            Config::set('session.lifetime', $sessionTimeout);
        }

        return $next($request);
    }
}
