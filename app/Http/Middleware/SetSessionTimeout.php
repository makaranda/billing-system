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
            $sessionTimeout = Auth::user()->session_timeout;
            $lastActivity = session('lastActivityTime');
            $currentTime = now();

            if ($lastActivity !== null && $currentTime->diffInMinutes($lastActivity) >= $sessionTimeout) {
                Auth::logout();
                session()->invalidate();

                return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
            }

            session(['lastActivityTime' => $currentTime]);
        }

        return $next($request);

    }
}
