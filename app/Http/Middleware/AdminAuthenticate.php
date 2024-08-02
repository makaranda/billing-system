<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AdminAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login.index');
    }

    protected function authenticate($request, array $guards)
    {
        if (Auth::guard('admin')->check()) {
            return $this->auth->shouldUse('admin');
        }

        $this->unauthenticated($request, ['admin']);
    }
}

