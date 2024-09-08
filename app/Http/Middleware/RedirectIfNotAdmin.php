<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type !== 'Admin') {
            return redirect()->route('dashboard'); // Redirect to normal user dashboard
        }

        return $next($request);
    }
}
