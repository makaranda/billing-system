<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //dd(Auth::user()->status);
        if (Auth::check()) {
            $user = Auth::user();

            if ($user && $user->status !== 1) {
                Auth::guard('admin')->logout();
                return redirect('/')->withErrors(['Your account is inactive.']);
            }
        }

        return $next($request);
    }
}
