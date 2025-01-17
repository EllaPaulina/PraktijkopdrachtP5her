<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('AdminMiddleware is being called');

        if (Auth::check() && Auth::user()->is_admin === 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
