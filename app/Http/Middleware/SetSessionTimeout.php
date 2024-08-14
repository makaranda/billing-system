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
            $sessionTimeout = Auth::user()->session_timeout; // This should be an integer

            // Ensure sessionTimeout is an integer
            if (is_int($sessionTimeout)) {
                Config::set('session.lifetime', $sessionTimeout);
            } else {
                // Fallback to default session lifetime if it's not an integer
                Config::set('session.lifetime', env('SESSION_LIFETIME', 120));
            }
        }

        return $next($request);
    }
}
